/*
 * File trung gian: static imports → tree-shaking đúng.
 * Dynamic import('./echarts-radar.js') từ app.js → lazy load đúng.
 */
import * as echarts from 'echarts/core';
import { RadarChart }       from 'echarts/charts';
import { TooltipComponent } from 'echarts/components';
import { CanvasRenderer }   from 'echarts/renderers';

echarts.use([RadarChart, TooltipComponent, CanvasRenderer]);

export { echarts };
