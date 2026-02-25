{{-- @block id="simple-animated-counter" label="Simple Animated Counter" description="A simple animated counter that works with GrapesJS" --}}
@php $isEditorPreview = $isEditorPreview ?? false; @endphp
@if($isEditorPreview)
<div class="simple-counter-block py-12" style="background-color: var(--laralgrape-primary-50);">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-8" style="color: var(--laralgrape-primary-900);">Our Numbers</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="counter-item p-6 rounded-lg shadow-lg" style="background-color: var(--laralgrape-primary-100);">
                <div class="text-4xl font-bold mb-2" style="color: var(--laralgrape-accent);">150+</div>
                <div class="text-lg font-semibold" style="color: var(--laralgrape-primary-700);">Projects Completed</div>
            </div>
            <div class="counter-item p-6 rounded-lg shadow-lg" style="background-color: var(--laralgrape-primary-100);">
                <div class="text-4xl font-bold mb-2" style="color: var(--laralgrape-accent);">50+</div>
                <div class="text-lg font-semibold" style="color: var(--laralgrape-primary-700);">Happy Clients</div>
            </div>
            <div class="counter-item p-6 rounded-lg shadow-lg" style="background-color: var(--laralgrape-primary-100);">
                <div class="text-4xl font-bold mb-2" style="color: var(--laralgrape-accent);">5+</div>
                <div class="text-lg font-semibold" style="color: var(--laralgrape-primary-700);">Years Experience</div>
            </div>
        </div>
    </div>
</div>
@else
<div class="simple-counter-block py-12" 
     style="background-color: var(--laralgrape-primary-50);" 
     data-gjs-type="default" 
     data-gjs-draggable="true" 
     data-gjs-droppable="false"
     x-data="{ 
         counters: [
             { target: 150, current: 0, suffix: '+', label: 'Projects Completed' },
             { target: 50, current: 0, suffix: '+', label: 'Happy Clients' },
             { target: 5, current: 0, suffix: '+', label: 'Years Experience' }
         ],
         animated: false
     }" 
     x-init="
         (() => {
         if (window.IS_GRAPESJS_EDITOR || document.body.classList.contains('is-grapesjs-canvas')) {
             animated = true;
             counters.forEach((c) => { c.current = c.target; });
         } else {
             const observer = new IntersectionObserver((entries) => {
                 entries.forEach(entry => {
                     if (entry.isIntersecting && !animated) {
                         animated = true;
                         counters.forEach((counter, index) => {
                             setTimeout(() => {
                                 const duration = 2000;
                                 const increment = counter.target / (duration / 16);
                                 const timer = setInterval(() => {
                                     counter.current += increment;
                                     if (counter.current >= counter.target) {
                                         counter.current = counter.target;
                                         clearInterval(timer);
                                     }
                                 }, 16);
                             }, index * 200);
                         });
                     }
                 });
             });
             observer.observe($el);
         }
         })();
     ">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-8" style="color: var(--laralgrape-primary-900);" data-gjs-type="text" data-gjs-name="counter-title">Our Numbers</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <template x-for="(counter, index) in counters" :key="index">
                <div class="counter-item p-6 rounded-lg shadow-lg transition-all duration-300 hover:scale-105" 
                     style="background-color: var(--laralgrape-primary-100);"
                     data-gjs-type="default" 
                     data-gjs-droppable="false">
                    <div class="text-4xl font-bold mb-2" style="color: var(--laralgrape-accent);">
                        <span x-text="Math.floor(counter.current)"></span><span x-text="counter.suffix"></span>
                    </div>
                    <div class="text-lg font-semibold" style="color: var(--laralgrape-primary-700);" x-text="counter.label"></div>
                </div>
            </template>
        </div>
    </div>
</div>
@endif 