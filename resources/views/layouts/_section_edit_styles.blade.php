<style>
/* ============================================================
   EDUCOREXA — Section Edit Page Premium Styles
   Shared across all frontend section edit views
   ============================================================ */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');

/* ---- Page header ---- */
.se-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 14px;
    margin-bottom: 28px;
}
.se-header__left { display: flex; align-items: center; gap: 14px; }
.se-header__icon {
    width: 48px; height: 48px;
    background: linear-gradient(135deg, #0061A8, #0080d4);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; color: #fff;
    box-shadow: 0 6px 18px rgba(0,97,168,0.3);
    flex-shrink: 0;
}
.se-header__title {
    font-family: 'Poppins', sans-serif;
    font-size: 1.3rem; font-weight: 800;
    color: #1e293b; margin: 0;
    letter-spacing: -0.3px;
}
.se-header__sub { font-size: 0.82rem; color: #64748b; margin: 3px 0 0; }

/* ---- Main card ---- */
.se-card {
    background: #fff;
    border-radius: 20px;
    border: 1.5px solid rgba(0,97,168,0.08);
    box-shadow: 0 4px 28px rgba(0,97,168,0.07);
    overflow: hidden;
    font-family: 'Poppins', sans-serif;
    margin-bottom: 24px;
}

.se-card__head {
    padding: 20px 28px;
    border-bottom: 1px solid #f1f5f9;
    display: flex; align-items: center; gap: 12px;
    background: linear-gradient(135deg, #f8fbff 0%, #f0f7ff 100%);
}
.se-card__head-dot {
    width: 10px; height: 10px;
    background: linear-gradient(135deg, #0061A8, #0080d4);
    border-radius: 50%;
    flex-shrink: 0;
}
.se-card__head-title {
    font-size: 15px; font-weight: 700;
    color: #1e293b; margin: 0;
}
.se-card__head-badge {
    margin-left: auto;
    background: #e8f3fb;
    color: #0061A8;
    font-size: 11px; font-weight: 700;
    padding: 4px 12px; border-radius: 50px;
    border: 1px solid rgba(0,97,168,0.2);
}

.se-card__body { padding: 28px; }

/* ---- Section dividers ---- */
.se-section-label {
    display: flex; align-items: center; gap: 10px;
    margin: 24px 0 16px;
}
.se-section-label__line {
    flex: 1; height: 1px;
    background: linear-gradient(90deg, rgba(0,97,168,0.15), transparent);
    border-radius: 4px;
}
.se-section-label__text {
    font-size: 10.5px; font-weight: 800;
    color: #94a3b8;
    text-transform: uppercase; letter-spacing: 0.12em;
    white-space: nowrap;
}

/* ---- Form fields ---- */
.se-label {
    font-size: 12.5px; font-weight: 700;
    color: #374151; margin-bottom: 6px;
    display: block;
}
.se-label span {
    color: #ef4444; margin-left: 2px;
}
.se-hint {
    font-size: 11.5px; color: #94a3b8;
    margin-top: 4px; display: block;
    font-weight: 400;
}


.se-input,
.se-select,
.se-textarea {
    width: 100%;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 14px;
    font-family: 'Poppins', sans-serif;
    color: #1e293b;
    background: #fff;
    transition: border-color 0.22s, box-shadow 0.22s;
    outline: none;
}
.se-input:focus,
.se-select:focus,
.se-textarea:focus {
    border-color: #0061A8;
    box-shadow: 0 0 0 3px rgba(0,97,168,0.10);
}
.se-textarea { resize: vertical; min-height: 90px; }

/* ---- Image upload box ---- */
.se-img-box {
    border: 2px dashed rgba(0,97,168,0.25);
    border-radius: 16px;
    padding: 20px;
    background: #f8fbff;
    text-align: center;
    transition: border-color 0.25s, background 0.25s;
    cursor: pointer;
}
.se-img-box:hover {
    border-color: #0061A8;
    background: #eef6ff;
}
.se-img-box__preview {
    max-width: 260px;
    max-height: 180px;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 14px rgba(0,97,168,0.1);
    object-fit: cover;
    display: block;
    margin: 0 auto 12px;
    transition: transform 0.3s;
}
.se-img-box:hover .se-img-box__preview { transform: scale(1.02); }
.se-img-box__label {
    font-size: 12.5px; font-weight: 600;
    color: #0061A8;
    display: flex; align-items: center; justify-content: center; gap: 6px;
}
.se-img-box__hint { font-size: 11px; color: #94a3b8; margin-top: 4px; }
.se-img-box > input[type="file"] { display: none; }

/* ---- Footer action bar ---- */
.se-action-bar {
    display: flex; align-items: center; gap: 12px;
    padding: 20px 28px;
    border-top: 1px solid #f1f5f9;
    background: #fafbff;
    flex-wrap: wrap;
}

.se-btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 10px 22px; border-radius: 10px;
    font-size: 13.5px; font-weight: 700;
    border: none; cursor: pointer;
    text-decoration: none; transition: all 0.25s;
    font-family: 'Poppins', sans-serif;
    white-space: nowrap;
}
.se-btn--primary {
    background: linear-gradient(135deg, #0061A8, #0080d4);
    color: #fff !important;
    box-shadow: 0 4px 16px rgba(0,97,168,0.3);
}
.se-btn--primary:hover {
    background: linear-gradient(135deg, #004c84, #0061A8);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,97,168,0.4);
    color: #fff !important; text-decoration: none;
}
.se-btn--secondary {
    background: #fff;
    color: #475569;
    border: 1.5px solid #e2e8f0;
}
.se-btn--secondary:hover {
    border-color: #0061A8; color: #0061A8;
    text-decoration: none;
}

/* ---- Responsive ---- */
@media (max-width: 767px) {
    .se-card__body { padding: 18px 16px; }
    .se-card__head { padding: 16px 18px; }
    .se-action-bar { padding: 16px 18px; }
    .se-header { flex-direction: column; align-items: flex-start; }
}
@media (max-width: 479px) {
    .se-btn { width: 100%; justify-content: center; }
}
</style>
