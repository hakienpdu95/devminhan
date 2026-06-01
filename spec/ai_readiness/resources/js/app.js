import Alpine from 'alpinejs';
import { surveyApp } from './survey/app.js';

// expose the factory so `x-data="surveyApp()"` resolves in the Blade view
window.surveyApp = surveyApp;
window.Alpine = Alpine;

Alpine.start();
