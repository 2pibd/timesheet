<div>
    <label for="invoice_number" class="block font-medium text-sm text-gray-700">{{ 'Invoice Number' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="invoice_number" name="invoice_number" type="text" value="{{ isset($invoice->invoice_number) ? $invoice->invoice_number : ''}}" required>
    {!! $errors->first('invoice_number', '<p>:message</p>') !!}
</div>
<div>
    <label for="invoice_contact" class="block font-medium text-sm text-gray-700">{{ 'Invoice Contact' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="invoice_contact" name="invoice_contact" type="text" value="{{ isset($invoice->invoice_contact) ? $invoice->invoice_contact : ''}}" >
    {!! $errors->first('invoice_contact', '<p>:message</p>') !!}
</div>
<div>
    <label for="invoice_date" class="block font-medium text-sm text-gray-700">{{ 'Invoice Date' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="invoice_date" name="invoice_date" type="text" value="{{ isset($invoice->invoice_date) ? $invoice->invoice_date : ''}}" >
    {!! $errors->first('invoice_date', '<p>:message</p>') !!}
</div>
<div>
    <label for="employer_ref" class="block font-medium text-sm text-gray-700">{{ 'Employer Ref' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="employer_ref" name="employer_ref" type="text" value="{{ isset($invoice->employer_ref) ? $invoice->employer_ref : ''}}" >
    {!! $errors->first('employer_ref', '<p>:message</p>') !!}
</div>
<div>
    <label for="tax_year" class="block font-medium text-sm text-gray-700">{{ 'Tax Year' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="tax_year" name="tax_year" type="text" value="{{ isset($invoice->tax_year) ? $invoice->tax_year : ''}}" >
    {!! $errors->first('tax_year', '<p>:message</p>') !!}
</div>
<div>
    <label for="posted_to" class="block font-medium text-sm text-gray-700">{{ 'Posted To' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="posted_to" name="posted_to" type="text" value="{{ isset($invoice->posted_to) ? $invoice->posted_to : ''}}" >
    {!! $errors->first('posted_to', '<p>:message</p>') !!}
</div>
<div>
    <label for="invoice_printed" class="block font-medium text-sm text-gray-700">{{ 'Invoice Printed' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="invoice_printed" name="invoice_printed" type="text" value="{{ isset($invoice->invoice_printed) ? $invoice->invoice_printed : ''}}" >
    {!! $errors->first('invoice_printed', '<p>:message</p>') !!}
</div>
<div>
    <label for="invoice_net" class="block font-medium text-sm text-gray-700">{{ 'Invoice Net' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="invoice_net" name="invoice_net" type="text" value="{{ isset($invoice->invoice_net) ? $invoice->invoice_net : ''}}" >
    {!! $errors->first('invoice_net', '<p>:message</p>') !!}
</div>
<div>
    <label for="invoice_vat" class="block font-medium text-sm text-gray-700">{{ 'Invoice Vat' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="invoice_vat" name="invoice_vat" type="text" value="{{ isset($invoice->invoice_vat) ? $invoice->invoice_vat : ''}}" >
    {!! $errors->first('invoice_vat', '<p>:message</p>') !!}
</div>
<div>
    <label for="invoice_total" class="block font-medium text-sm text-gray-700">{{ 'Invoice Total' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="invoice_total" name="invoice_total" type="text" value="{{ isset($invoice->invoice_total) ? $invoice->invoice_total : ''}}" >
    {!! $errors->first('invoice_total', '<p>:message</p>') !!}
</div>


<div class="flex items-center gap-4">
    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
        {{ $formMode === 'edit' ? 'Update' : 'Create' }}
    </button>
</div>
