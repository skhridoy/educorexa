<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdCardDesign extends Model
{
    protected $fillable = [
        'name', 'slug',
        'header_shape', 'gradient_bar', 'pattern',
        'primary_color', 'badge_color', 'label_color',
        'photo_border_color', 'back_header_bg', 'back_header_text',
        'is_active', 'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    // ── Scopes ──────────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // ── URL Helpers ──────────────────────────────────────────
    public function getHeaderShapeUrlAttribute(): ?string
    {
        return $this->header_shape ? asset($this->header_shape) : null;
    }

    public function getGradientBarUrlAttribute(): ?string
    {
        return $this->gradient_bar ? asset($this->gradient_bar) : null;
    }

    public function getPatternUrlAttribute(): ?string
    {
        return $this->pattern ? asset($this->pattern) : null;
    }

    // ── Public-path helpers (for DomPDF) ─────────────────────
    public function getHeaderShapePathAttribute(): ?string
    {
        return $this->header_shape ? public_path($this->header_shape) : null;
    }

    public function getGradientBarPathAttribute(): ?string
    {
        return $this->gradient_bar ? public_path($this->gradient_bar) : null;
    }

    public function getPatternPathAttribute(): ?string
    {
        return $this->pattern ? public_path($this->pattern) : null;
    }

    /**
     * Return primary colour as [r, g, b] array for QR SVG tinting.
     */
    public function getRgbAttribute(): array
    {
        $hex = ltrim($this->primary_color, '#');
        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }
        return [
            hexdec(substr($hex, 0, 2)),
            hexdec(substr($hex, 2, 2)),
            hexdec(substr($hex, 4, 2)),
        ];
    }
}
