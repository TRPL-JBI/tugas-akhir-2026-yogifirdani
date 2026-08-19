import './bootstrap';
import Alpine from 'alpinejs';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';

window.Alpine = Alpine;
window.flatpickr = flatpickr;
Alpine.start();

// Initialize components on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    // Map imports
    if (document.querySelector('#mapOne')) {
        import('./components/map').then(module => module.initMap());
    }

    // Dynamic ApexCharts Loading (Code Splitting)
    const hasCharts = document.querySelector('#chartOne') || 
                      document.querySelector('#chartTwo') || 
                      document.querySelector('#chartThree') || 
                      document.querySelector('#chartSix') || 
                      document.querySelector('#chartEight') || 
                      document.querySelector('#chartThirteen');
                      
    if (hasCharts) {
        import('apexcharts').then(({ default: ApexCharts }) => {
            window.ApexCharts = ApexCharts;
            
            if (document.querySelector('#chartOne')) {
                import('./components/chart/chart-1').then(module => module.initChartOne());
            }
            if (document.querySelector('#chartTwo')) {
                import('./components/chart/chart-2').then(module => module.initChartTwo());
            }
            if (document.querySelector('#chartThree')) {
                import('./components/chart/chart-3').then(module => module.initChartThree());
            }
            if (document.querySelector('#chartSix')) {
                import('./components/chart/chart-6').then(module => module.initChartSix());
            }
            if (document.querySelector('#chartEight')) {
                import('./components/chart/chart-8').then(module => module.initChartEight());
            }
            if (document.querySelector('#chartThirteen')) {
                import('./components/chart/chart-13').then(module => module.initChartThirteen());
            }
        });
    }

    // Dynamic FullCalendar Loading (Code Splitting)
    if (document.querySelector('#calendar')) {
        import('@fullcalendar/core').then(({ Calendar }) => {
            window.FullCalendar = Calendar;
            import('./components/calendar-init').then(module => module.calendarInit());
        });
    }
});
