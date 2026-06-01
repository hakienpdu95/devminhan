/*
 * AI Readiness — page entry.
 * Loaded via @vite in head_extra (trước app.js để window.aiReadiness sẵn
 * khi Alpine evaluate x-data="aiReadiness()").
 */
import { aiReadiness } from '@js/survey/ai-readiness/app.js';

window.aiReadiness = aiReadiness;
