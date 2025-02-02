<div>
    <label for="industry" class="block font-medium text-sm text-gray-700">{{ 'Industry' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="industry" name="industry" type="text" value="{{ isset($industry->industry) ? $industry->industry : ''}}" required>
    {!! $errors->first('industry', '<p>:message</p>') !!}
</div>
<div>
    <label for="is_active" class="block font-medium text-sm text-gray-700">{{ 'Is Active' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="is_active" name="is_active" type="text" value="{{ isset($industry->is_active) ? $industry->is_active : ''}}" >
    {!! $errors->first('is_active', '<p>:message</p>') !!}
</div>
<div>
    <label for="sort_order" class="block font-medium text-sm text-gray-700">{{ 'Sort Order' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="sort_order" name="sort_order" type="text" value="{{ isset($industry->sort_order) ? $industry->sort_order : ''}}" >
    {!! $errors->first('sort_order', '<p>:message</p>') !!}
</div>


<div class="flex items-center gap-4">
    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
        {{ $formMode === 'edit' ? 'Update' : 'Create' }}
    </button>
</div>
