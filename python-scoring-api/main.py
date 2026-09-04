import re
from typing import List
from fastapi import FastAPI, HTTPException
from pydantic import BaseModel
from sentence_transformers import SentenceTransformer, util
import numpy as np

app = FastAPI(
    title="CV Screening AI Microservice",
    description="Semantic embedding and keyword scoring microservice for CV matching."
)

# Load lightweight all-MiniLM-L6-v2 model on startup
print("Loading Transformer Model (all-MiniLM-L6-v2)...")
model = SentenceTransformer("all-MiniLM-L6-v2")
print("Model loaded successfully.")


class CandidateInput(BaseModel):
    id: int
    text: str


class ScoreRequest(BaseModel):
    job_description: str
    candidates: List[CandidateInput]


class CandidateRanking(BaseModel):
    candidate_id: int
    score: float
    embedding_score: float
    keyword_score: float


class ScoreResponse(BaseModel):
    status: str
    total_candidates: int
    rankings: List[CandidateRanking]


def calculate_keyword_score(job_desc: str, cv_text: str) -> float:
    """Computes basic keyword overlap between Job Description and CV text."""
    def extract_words(text: str):
        # Captures tech words with +, #, ., and allows 2+ character terms (e.g., JS, AI, C++, .NET)
        words = re.findall(r'\b[a-zA-Z0-9+#.]{2,}\b', text.lower())
        return set(words)

    job_words = extract_words(job_desc)
    if not job_words:
        return 0.0

    cv_words = extract_words(cv_text)
    common_words = job_words.intersection(cv_words)
    
    return float(len(common_words) / len(job_words))

@app.get("/")
def health_check():
    return {"status": "online", "model": "all-MiniLM-L6-v2"}


@app.post("/score", response_model=ScoreResponse)
def score_candidates(payload: ScoreRequest):
    if not payload.job_description.strip():
        raise HTTPException(status_code=400, detail="Job description cannot be empty.")
    if not payload.candidates:
        return ScoreResponse(status="success", total_candidates=0, rankings=[])

    # 1. Encode job description vector
    job_embedding = model.encode(payload.job_description, convert_to_tensor=True)

    # 2. Collect candidate texts and compute embeddings in batch
    candidate_texts = [c.text if c.text.strip() else "N/A" for c in payload.candidates]
    candidate_embeddings = model.encode(candidate_texts, convert_to_tensor=True)

    # 3. Calculate Cosine Similarities
    cosine_scores = util.cos_sim(job_embedding, candidate_embeddings)[0].tolist()

    rankings = []
    for idx, candidate in enumerate(payload.candidates):
        emb_score = max(0.0, min(1.0, float(cosine_scores[idx])))
        key_score = calculate_keyword_score(payload.job_description, candidate.text)

        # Hybrid Score: 70% Semantic Embedding + 30% Keyword Overlap
        hybrid_score = round((0.7 * emb_score) + (0.3 * key_score), 4)

        rankings.append(
            CandidateRanking(
                candidate_id=candidate.id,
                score=hybrid_score,
                embedding_score=round(emb_score, 4),
                keyword_score=round(key_score, 4)
            )
        )

    # Sort rankings by overall hybrid score descending
    rankings.sort(key=lambda x: x.score, reverse=True)

    return ScoreResponse(
        status="success",
        total_candidates=len(rankings),
        rankings=rankings
    )