{{-- @block id="form-block" label="Form Block" description="A dynamic form block with theme support" --}}
<div class="dynamic-form-block max-w-2xl mx-auto py-8">
    <form class="bg-primary-50 dark:bg-primary-900 shadow-lg rounded-lg p-8 border-2 border-primary-200 dark:border-primary-800">
        <h3 class="text-2xl font-bold mb-6 text-center text-primary-900 dark:text-primary-100" data-gjs-type="text" data-gjs-name="form-title">{{ $form->name }}</h3>
        @foreach ($form->fields as $field)
            <div class="mb-4">
                <label class="block text-primary-800 dark:text-primary-100 text-sm font-bold mb-2" for="field-{{ $field->id }}">{{ $field->label }}</label>
                @if ($field->type === 'text')
                    <input type="text" id="field-{{ $field->id }}" name="field_{{ $field->id }}" class="shadow appearance-none border border-primary-300 dark:border-primary-700 rounded w-full py-2 px-3 text-primary-900 dark:text-primary-100 bg-primary-50 dark:bg-primary-900 leading-tight focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" @if($field->required) required @endif>
                @elseif ($field->type === 'email')
                    <input type="email" id="field-{{ $field->id }}" name="field_{{ $field->id }}" class="shadow appearance-none border border-primary-300 dark:border-primary-700 rounded w-full py-2 px-3 text-primary-900 dark:text-primary-100 bg-primary-50 dark:bg-primary-900 leading-tight focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" @if($field->required) required @endif>
                @elseif ($field->type === 'textarea')
                    <textarea id="field-{{ $field->id }}" name="field_{{ $field->id }}" rows="4" class="shadow appearance-none border border-primary-300 dark:border-primary-700 rounded w-full py-2 px-3 text-primary-900 dark:text-primary-100 bg-primary-50 dark:bg-primary-900 leading-tight focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" @if($field->required) required @endif></textarea>
                @elseif ($field->type === 'select' && is_array($field->options))
                    <select id="field-{{ $field->id }}" name="field_{{ $field->id }}" class="shadow appearance-none border border-primary-300 dark:border-primary-700 rounded w-full py-2 px-3 text-primary-900 dark:text-primary-100 bg-primary-50 dark:bg-primary-900 leading-tight focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" @if($field->required) required @endif>
                        @foreach ($field->options as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    </select>
                @endif
            </div>
        @endforeach
        <div class="text-center">
            <button type="submit" class="bg-primary-600 dark:bg-primary-400 hover:bg-primary-700 dark:hover:bg-primary-300 text-primary-50 dark:text-primary-900 font-bold py-2 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2 shadow transition-colors">Submit</button>
        </div>
    </form>
</div>