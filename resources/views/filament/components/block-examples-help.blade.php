<div class="prose max-w-none text-primary-700">
    <h2 class="text-2xl font-extrabold text-primary-900 mb-4">Block Examples &amp; Conventions</h2>
    <h3 class="text-xl font-bold text-accent mb-2">HTML Example</h3>
    <pre class="bg-primary-100 text-primary-900 p-4 rounded-xl overflow-x-auto border-l-4 border-accent shadow"><code>&lt;div class="custom-block bg-gradient"&gt;
    &lt;h2 data-gjs-type="text" data-gjs-name="title"&gt;Block Title&lt;/h2&gt;
    &lt;p data-gjs-type="text" data-gjs-name="description"&gt;Block description goes here.&lt;/p&gt;
    &lt;button class="block-btn" data-gjs-type="text" data-gjs-name="button-text"&gt;Click Me&lt;/button&gt;
&lt;/div&gt;
</code></pre>
    <h3 class="text-xl font-bold text-accent mb-2">CSS Example</h3>
    <pre class="bg-primary-100 text-primary-900 p-4 rounded-xl overflow-x-auto border-l-4 border-accent shadow"><code>.custom-block {
    padding: 2rem;
    border-radius: 1rem;
    background: linear-gradient(135deg, #9333ea 0%, #6d28d9 100%);
    color: #fff;
    text-align: center;
}
.block-btn {
    background: #fff;
    color: #9333ea;
    border: none;
    padding: 0.75rem 2rem;
    border-radius: 2rem;
    font-weight: 600;
    cursor: pointer;
}
</code></pre>
    <h3 class="text-xl font-bold text-accent mb-2">PHP/Blade Example</h3>
    <pre class="bg-primary-100 text-primary-900 p-4 rounded-xl overflow-x-auto border-l-4 border-accent shadow"><code>@php
    $greeting = 'Hello, ' . ($name ?? 'World') . '!';
@endphp
&lt;div&gt;@{{ $greeting }}&lt;/div&gt;
</code></pre>
    <h3 class="text-xl font-bold text-accent mb-2">Conventions</h3>
    <ul class="text-primary-900 space-y-2">
        <li>
            <span class="font-bold">data-gjs-type</span>:
            Used by GrapesJS to make elements editable (e.g.,
            <code class="bg-primary-200 px-1 rounded">data-gjs-type="text"</code>).
        </li>
        <li>
            <span class="font-bold">data-gjs-name</span>:
            Unique name for each editable element (e.g.,
            <code class="bg-primary-200 px-1 rounded">data-gjs-name="title"</code>).
        </li>
        <li>
            <span class="font-bold">Blade Variables</span>:
            You can use variables like
            <code class="bg-primary-200 px-1 rounded">@{{ $title }}</code>
            or
            <code class="bg-primary-200 px-1 rounded">@{{ $content }}</code>
            in PHP/Blade blocks.
        </li>
    </ul>
    <h3 class="text-xl font-bold text-accent mb-2">Tips</h3>
    <ul class="text-primary-900 space-y-2">
        <li>Use clear, unique <code class="bg-primary-200 px-1 rounded">data-gjs-name</code> attributes for each editable part.</li>
        <li>Keep your CSS scoped to your block to avoid style conflicts.</li>
        <li>Only trusted users should edit PHP/Blade code.</li>
    </ul>
</div> 