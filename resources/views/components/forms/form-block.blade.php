{{-- Form Block for GrapesJS
<div class="dynamic-form-block max-w-2xl mx-auto py-8">
    <form class="bg-white shadow-lg rounded-lg p-8">
        <h3 class="text-2xl font-bold mb-6 text-center" data-gjs-type="text" data-gjs-name="form-title">{{ $form->name }}</h3>
        @foreach ($form->fields as $field)
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="field-{{ $field->id }}">{{ $field->label }}</label>
                @if ($field->type === 'text')
                    <input type="text" id="field-{{ $field->id }}" name="field_{{ $field->id }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" @if($field->required) required @endif>
                @elseif ($field->type === 'email')
                    <input type="email" id="field-{{ $field->id }}" name="field_{{ $field->id }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" @if($field->required) required @endif>
                @elseif ($field->type === 'textarea')
                    <textarea id="field-{{ $field->id }}" name="field_{{ $field->id }}" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" @if($field->required) required @endif></textarea>
                @elseif ($field->type === 'select' && is_array($field->options))
                    <select id="field-{{ $field->id }}" name="field_{{ $field->id }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" @if($field->required) required @endif>
                        @foreach ($field->options as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    </select>
                @endif
            </div>
        @endforeach
        <div class="text-center">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button>
        </div>
    </form>
</div>  --}}