<div class="prose max-w-none">
    <h2>Block Examples &amp; Conventions</h2>
    <h3>HTML Example</h3>
    <pre class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100 p-4 rounded overflow-x-auto"><code>&lt;div class="custom-block bg-gradient"&gt;
    &lt;h2 data-gjs-type="text" data-gjs-name="title"&gt;Block Title&lt;/h2&gt;
    &lt;p data-gjs-type="text" data-gjs-name="description"&gt;Block description goes here.&lt;/p&gt;
    &lt;button class="block-btn" data-gjs-type="text" data-gjs-name="button-text"&gt;Click Me&lt;/button&gt;
&lt;/div&gt;
</code></pre>
    <h3>CSS Example</h3>
    <pre class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100 p-4 rounded overflow-x-auto"><code>.custom-block {
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
    <h3>PHP/Blade Example</h3>
    <pre class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100 p-4 rounded overflow-x-auto"><code>@php
    $greeting = 'Hello, ' . ($name ?? 'World') . '!';
@endphp
&lt;div&gt;@{{ $greeting }}&lt;/div&gt;
</code></pre>
    <h3>Conventions</h3>
    <ul class="dark:text-white text-gray-800 space-y-2">
        <li>
            <span class="font-bold">data-gjs-type</span>:
            Used by GrapesJS to make elements editable (e.g.,
            <code class="bg-gray-200 dark:bg-white px-1 rounded">data-gjs-type="text"</code>).
        </li>
        <li>
            <span class="font-bold">data-gjs-name</span>:
            Unique name for each editable element (e.g.,
            <code class="bg-gray-200 dark:bg-white px-1 rounded">data-gjs-name="title"</code>).
        </li>
        <li>
            <span class="font-bold">Blade Variables</span>:
            You can use variables like
            <code class="bg-gray-200 dark:bg-white px-1 rounded">@{{ $title }}</code>
            or
            <code class="bg-gray-200 dark:bg-white px-1 rounded">@{{ $content }}</code>
            in PHP/Blade blocks.
        </li>
    </ul>
    <h3>Tips</h3>
    <ul class="dark:text-white text-gray-800 space-y-2">
        <li>Use clear, unique <code class="bg-gray-200 dark:bg-white  px-1 rounded">data-gjs-name</code> attributes for each editable part.</li>
        <li>Keep your CSS scoped to your block to avoid style conflicts.</li>
        <li>Only trusted users should edit PHP/Blade code.</li>
    </ul>
</div> 