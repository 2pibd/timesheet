<div class="mb-3">
    <label for="employer_id" class="block font-medium text-sm text-gray-700">{{ 'Employer Id' }}</label>
    <input class="form-control" id="employer_id" name="employer_id" type="text" value="{{ isset($supplier->employer_id) ? $supplier->employer_id : ''}}" required>
    {!! $errors->first('employer_id', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="supplier_ref" class="block font-medium text-sm text-gray-700">{{ 'Supplier Ref' }}</label>
    <input class="form-control" id="supplier_ref" name="supplier_ref" type="text" value="{{ isset($supplier->supplier_ref) ? $supplier->supplier_ref : ''}}" >
    {!! $errors->first('supplier_ref', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="business_name" class="block font-medium text-sm text-gray-700">{{ 'Business Name' }}</label>
    <input class="form-control" id="business_name" name="business_name" type="text" value="{{ isset($supplier->business_name) ? $supplier->business_name : ''}}" >
    {!! $errors->first('business_name', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="department" class="block font-medium text-sm text-gray-700">{{ 'Department' }}</label>
    <input class="form-control" id="department" name="department" type="text" value="{{ isset($supplier->department) ? $supplier->department : ''}}" >
    {!! $errors->first('department', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="division" class="block font-medium text-sm text-gray-700">{{ 'Division' }}</label>
    <input class="form-control" id="division" name="division" type="text" value="{{ isset($supplier->division) ? $supplier->division : ''}}" >
    {!! $errors->first('division', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="legal_status" class="block font-medium text-sm text-gray-700">{{ 'Legal Status' }}</label>
    <input class="form-control" id="legal_status" name="legal_status" type="text" value="{{ isset($supplier->legal_status) ? $supplier->legal_status : ''}}" >
    {!! $errors->first('legal_status', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="supplier_type" class="block font-medium text-sm text-gray-700">{{ 'Supplier Type' }}</label>
    <input class="form-control" id="supplier_type" name="supplier_type" type="text" value="{{ isset($supplier->supplier_type) ? $supplier->supplier_type : ''}}" >
    {!! $errors->first('supplier_type', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="remittance_to" class="block font-medium text-sm text-gray-700">{{ 'Remittance To' }}</label>
    <input class="form-control" id="remittance_to" name="remittance_to" type="text" value="{{ isset($supplier->remittance_to) ? $supplier->remittance_to : ''}}" >
    {!! $errors->first('remittance_to', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="payment_option" class="block font-medium text-sm text-gray-700">{{ 'Payment Option' }}</label>
    <input class="form-control" id="payment_option" name="payment_option" type="text" value="{{ isset($supplier->payment_option) ? $supplier->payment_option : ''}}" >
    {!! $errors->first('payment_option', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="incorpotrate_date" class="block font-medium text-sm text-gray-700">{{ 'Incorpotrate Date' }}</label>
    <input class="form-control" id="incorpotrate_date" name="incorpotrate_date" type="text" value="{{ isset($supplier->incorpotrate_date) ? $supplier->incorpotrate_date : ''}}" >
    {!! $errors->first('incorpotrate_date', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="company_reg_no" class="block font-medium text-sm text-gray-700">{{ 'Company Reg No' }}</label>
    <input class="form-control" id="company_reg_no" name="company_reg_no" type="text" value="{{ isset($supplier->company_reg_no) ? $supplier->company_reg_no : ''}}" >
    {!! $errors->first('company_reg_no', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="schedule_date" class="block font-medium text-sm text-gray-700">{{ 'Schedule Date' }}</label>
    <input class="form-control" id="schedule_date" name="schedule_date" type="text" value="{{ isset($supplier->schedule_date) ? $supplier->schedule_date : ''}}" >
    {!! $errors->first('schedule_date', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="number" class="block font-medium text-sm text-gray-700">{{ 'Number' }}</label>
    <input class="form-control" id="number" name="number" type="text" value="{{ isset($supplier->number) ? $supplier->number : ''}}" >
    {!! $errors->first('number', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="vat_number" class="block font-medium text-sm text-gray-700">{{ 'Vat Number' }}</label>
    <input class="form-control" id="vat_number" name="vat_number" type="text" value="{{ isset($supplier->vat_number) ? $supplier->vat_number : ''}}" >
    {!! $errors->first('vat_number', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="vat_area" class="block font-medium text-sm text-gray-700">{{ 'Vat Area' }}</label>
    <input class="form-control" id="vat_area" name="vat_area" type="text" value="{{ isset($supplier->vat_area) ? $supplier->vat_area : ''}}" >
    {!! $errors->first('vat_area', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="vat_rate" class="block font-medium text-sm text-gray-700">{{ 'Vat Rate' }}</label>
    <input class="form-control" id="vat_rate" name="vat_rate" type="text" value="{{ isset($supplier->vat_rate) ? $supplier->vat_rate : ''}}" >
    {!! $errors->first('vat_rate', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="payment_terms" class="block font-medium text-sm text-gray-700">{{ 'Payment Terms' }}</label>
    <input class="form-control" id="payment_terms" name="payment_terms" type="text" value="{{ isset($supplier->payment_terms) ? $supplier->payment_terms : ''}}" >
    {!! $errors->first('payment_terms', '<p>:message</p>') !!}
</div>


<div class="flex items-center gap-4 text-end">
    <button type="submit" class="btn btn-primary">
        {{ $formMode === 'edit' ? 'Update' : 'Create' }}
    </button>
</div>
