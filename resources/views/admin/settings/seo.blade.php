
<h3>SEO</h3>

<form method="POST" action="{{ route('save_setting') }}" class="mt-6 space-y-6" id="form-settings-seo"
      accept-charset="UTF-8" enctype="multipart/form-data">
    @csrf()
    <div class=" {{ $errors->has('meta_keywords') ? 'has-error' : ''}} mb-3">
        <label for="meta_keywords" class="control-label">{{ 'Meta Keywords' }}  </label>
        <textarea class="form-control" name="settings[meta_keywords]" id="meta_keywords" rows=3 cols=50>{{$settings->meta_keywords ?? ''}}</textarea>
        {!! $errors->first('meta_keywords', '<p class="help-block">:message</p>') !!}

        <small class="text-muted" id="meta_keywords_feedback">
            Remaining characters: <span id="char_count">70</span>, Remaining keyword phrases: <span id="keyword_count">10</span>
        </small>
    </div>
    <div class=" {{ $errors->has('meta_description') ? 'has-error' : ''}} mb-3">
        <label for="meta_description" class="control-label">{{ 'Meta Description' }} </label>
        <textarea class="form-control" name="settings[meta_description]" id="meta_description" rows=5 cols=50  >{{$settings->meta_description ?? ''}}</textarea>
        Remaining characters: <span id="char_meta_description_count">160</span>
        {!! $errors->first('meta_description', '<p class="help-block">:message</p>') !!}
    </div>


    <div class="mb-3 text-end">
        <input class="btn btn-primary" type="submit" value="Save">
    </div>


</form>


<script>

    $(function () {

        var form_seo = $('#form-settings-seo');
        form_seo.submit(function (event) {
            event.preventDefault();

            // Get the meta_keywords value
            const metaKeywords = $('#meta_keywords').val();

            // Split meta_keywords by commas and trim spaces
            const keywordsArray = metaKeywords.split(',').map(keyword => keyword.trim());

            // Validate the total character count
            if (metaKeywords.length > 70) {
                alert("Meta keywords must not exceed 70 characters.");
                return false; // Prevent form submission
            }

            // Validate the number of keywords
            if (keywordsArray.length > 10) {
                alert("You can only add up to 10 keyword phrases.");
                return false; // Prevent form submission
            }

            var formData = new FormData(this);

            var form_status = $('<div class="form_status"></div>');
            //  $('#subnitBtn').prop('disabled', true);


            //  CKupdate();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                dataType: 'JSON',
                contentType: false, // Important: don't set content type
                processData: false, // Important: don't process data as a string
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {

                }
            }).done(function (data) {
                Swal.fire({
                    position: "top-center",
                    icon: "success",
                    title:  data.message,
                    showConfirmButton: false,
                    timer: 1500
                });

                //window.location.href = window.location
            }).fail(function () {
                alert("Error: Invalid Data");
            });
        });

        //////////////////////////////////////////////////////////
        const maxMetaDescription = 160;

        const maxKeywords = 10;
        const maxCharacters = 70;

        const metaKeywordsInput = $('#meta_keywords');
        const charCountElement = $('#char_count');
        const keywordCountElement = $('#keyword_count');

        metaKeywordsInput.on('input', function () {
            const inputValue = metaKeywordsInput.val();

            // Calculate remaining characters
            const remainingCharacters = maxCharacters - inputValue.length;
            charCountElement.text(remainingCharacters >= 0 ? remainingCharacters : 0);

            // Calculate remaining keyword phrases
            const keywordsArray = inputValue.split(',').map(keyword => keyword.trim()).filter(keyword => keyword !== "");
            const remainingKeywords = maxKeywords - keywordsArray.length;
            keywordCountElement.text(remainingKeywords >= 0 ? remainingKeywords : 0);

            // Style the feedback text if limits are exceeded
            if (remainingCharacters < 0 || remainingKeywords < 0) {
                $('#meta_keywords_feedback').css('color', 'red');
            } else {
                $('#meta_keywords_feedback').css('color', 'green');
            }
        });

///////////////////////////////////////////////////////////////////////
        const metaDiscriptionInput = $('#meta_description');
        const charMetaDiscriptionCountElement = $('#char_meta_description_count');

        metaDiscriptionInput.on('input', function () {
            const inputValue = metaDiscriptionInput.val();

            // Calculate remaining characters
            const remainingCharacters = maxCharacters - inputValue.length;
            charMetaDiscriptionCountElement.text(remainingCharacters >= 0 ? remainingCharacters : 0);

        });


    });
</script>
