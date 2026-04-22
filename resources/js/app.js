import './globals/theme.js'; /* By Sheaf.dev */ 
import './globals/modals.js';
    
import './bootstrap';
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';

import './components/select.js';

import Chart from 'chart.js/auto'

window.Chart = Chart

// now you can register
// components using Alpine.data(...) and
// plugins using Alpine.plugin(...) 


 
Livewire.start()