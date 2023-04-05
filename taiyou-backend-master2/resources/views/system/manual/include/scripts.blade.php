<script>
    $(document).ready(function () {
        $('#mansion_id').select2({});

    });
</script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    };

</script>
<script>
    $(function() {
        if ($("input[name='manual_type']:checked").val() == 0) {
            $("input[name='url']").attr('accept', 'video/*');

        } else {
            $("input[name='url']").attr('accept', 'application/pdf');
        }

        let uploadFileName = "";
        let fileUploadChangeStatus = false;
        let vid = document.createElement('url');

        $("#upload_file").on('change', function(e) {

            var fileURL = URL.createObjectURL(this.files[0]);
            vid.src = fileURL;
            vid.ondurationchange = function() {
                $("#duration").val(parseInt(this.duration));
            };
            if (e.target && e.target.files && e.target.files.length > 0 && e.target.files[0].name) {
                uploadFileName = e.target.files[0].name;
                $("#original_name").val(uploadFileName);
                fileUploadChangeStatus = true;
            }
        });

        $("input[name='manual_type']").on('change', function(e) {
            if ($(this).val() == 0) {
                $("input[name='url']").attr('accept', 'video/*');

            }
            if ($(this).val() == 1) {
                $("input[name='url']").attr('accept', 'application/pdf');
            }

        });

        $("#addVideoButton").on("click", function(e) {
            e.preventDefault();
            let validateStatus = validateForm(true);
            if (validateStatus) {
                uploadFile(uploadFileName, true)
            }
            return false;
        });

        $("#editVideoButton").on("click", function(e) {
            e.preventDefault();
            let validateStatus = validateForm(false);
            if (validateStatus) {
                if (document.getElementById("upload_file").files.length == 0) {
                    if (validateStatus) $("#Formid").submit();
                    return false;
                } else {
                    console.log(uploadFileName);
                    uploadFile(uploadFileName, false)
                    // S3RemoveFile();
                }
            }


        });

        function getSignedUrl(fileName, callback) {
            var radioValue = $("input[name='manual_type']:checked").val();
            $.ajax({
                url: '/system/upload-video-signed-url',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: 'POST',
                data: {
                    fileName: uploadFileName,
                    type: radioValue
                },
                success: function(data) {
                    $("#file_name").val(data.fileName);
                    callback(data);
                },
                error: function(error) {
                    callback(error);
                }
            });
        }

        function checkUnique(col, value, id) {
            let flag = true;
            $.ajax({
                url: '/system/manuals-check-unique',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: 'POST',
                data: {
                    value: value,
                    col: col,
                    id: id
                },
                success: function(data) {
                    flag = data;
                },
                async: false,
                error: function(error) {

                }
            });
            return flag;
        }

        function validateForm(status) {
            let flag = true;
            let manualid = $('[name="manual_id"]').val();
            let id = $('[name="id"]').val() ?? null;
            if (manualid.trim() != '') {
                let checkUnq = checkUnique('manual_id', manualid, id);
                if (checkUnq == false) {

                    $('[name="manual_id"]').addClass('is-invalid');
                    $('[name="manual_id"]').next().text("{{ translate('The manual Id must be unique') }}");
                    flag = false;
                } else {
                    $('[name="manual_id"]').removeClass('is-invalid');
                    $('[name="manual_id"]').next().text('');
                }
            } else {
                if ($('[name="manual_id"]').val().isEmpty()) {
                    $('[name="manual_id"]').addClass('is-invalid');
                    $('[name="manual_id"]').next().text(
                    "{{ translate('The manual Id field is required.') }}");
                    flag = false;

                } else {
                    $('[name="manual_id"]').removeClass('is-invalid');
                    $('[name="manual_id"]').next().next().text('');
                }
            }

            if ($('[name="flag"]').val().isEmpty()) {
                $('[name="flag"]').addClass('is-invalid');
                $('[name="flag"]').next().text("{{ translate('The manual status field is required.') }}");
                flag = false;

            }

            if ($('[name="name"]').val().isEmpty()) {
                $('[name="name"]').addClass('is-invalid');
                $('[name="name"]').next().text("{{ translate('The manual name field is required.') }}");
                flag = false;

            }

        //CHANGE FOR RADIO
            if (!$('[name="flag"]').is(":checked")) {
                $('[name="flag"]').addClass('is-invalid');
                $('.invalid-flag').text("{{ translate('The flag field is required.') }}");
                flag = false;

            } else {
                $('[name="flag"]').removeClass('is-invalid');
                $('.invalid-flag').text("");

            }
            if (!$('[name="manual_type"]').is(":checked")) {
                $('[name="manual_type"]').addClass('is-invalid');
                $('.invalid-manual-type').text("{{ translate('The manual type field is required.') }}");
                flag = false;

            } else {
                $('[name="manual_type"]').removeClass('is-invalid');
                $('.invalid-manual-type').text("");

            }
            //END OF RADIO
            if ($('[name="name"]').val().length >= 1 && $('[name="name"]').val().length < 3) {

                $('[name="name"]').addClass('is-invalid');
                $('[name="name"]').next().text(
                    "{{ translate('The name may not be less than 3 characters.') }}");
                flag = false;
            }
            if ($('[name="name"]').val().length > 255) {

                $('[name="name"]').addClass('is-invalid');
                $('[name="name"]').next().text(
                    "{{ translate('The name may not be greater than 255 characters.') }}");
                flag = false;
            }

            {{-- var regex=/^(?![0-9\s]*$)[a-zA-Z0-9\s]+$/; --}}
            {{-- var name = $('[name="name"]').val(); --}}
            {{-- if (!name.match(regex)) { --}}
            {{-- $('[name="name"]').addClass('is-invalid'); --}}
            {{-- $('[name="name"]').next().text( --}}
            {{-- "{{ translate('The name may cannot be number only.') }}"); --}}
            {{-- flag = false; --}}
            {{-- } --}}

            if (!$('[name="name"]').val().isEmpty() && $('[name="name"]').val().length >= 3 && $(
                    '[name="name"]').val().length <= 255) {
                $('[name="name"]').removeClass('is-invalid');
                $('[name="name"]').next().text('');
            }


            if (document.getElementById("upload_file").files.length == 0 && $('#old_filename').val() == null &&
                id != null) {
                $('[name="url"]').addClass('is-invalid');
                $('.invalid-url').text("{{ translate('The file is required.') }}");
                flag = false;
            } else if (document.getElementById("upload_file").files.length == 0 && id == null) {
                $('[name="url"]').addClass('is-invalid');
                $('.invalid-url').text("{{ translate('The file is required.') }}");
                flag = false;
            } else {
                $('[name="url"]').removeClass('is-invalid');
                $('.invalid-url').text('');
            }


            if ($('[name="manual_id"]').val().length > 255) {
                $('[name="manual_id"]').addClass('is-invalid');
                // $('[name="manual_id"]').next().text("マニュアルIDは、255文字以内に入力してください。");
                $('[name="manual_id"]').next().text(
                    "{{ translate('the manual id may not be greater than 255 characters') }}");
                flag = false;
            }

            var radioValue = $("input[name='manual_type']:checked").val();
            if (document.getElementById("upload_file").files.length > 0) {
                if (document.getElementById("upload_file").files[0].type != 'application/pdf' && radioValue ==
                    1) {

                    $('[name="url"]').addClass('is-invalid');
                    $('.invalid-url').text(
                    "{{ translate('The file must be  of type example.pdf format') }}");
                    flag = false;
                }

                if (document.getElementById("upload_file").files[0].type != 'video/mp4' && radioValue == 0) {
                    $('[name="url"]').addClass('is-invalid');
                    $('.invalid-url').text(
                    "{{ translate('The file must  be of type example.mp4 format') }}");
                    flag = false;
                }


                var radioValue = $("input[name='manual_type']:checked").val();
                if (document.getElementById("upload_file").files[0].size >= 105067315.2 && radioValue == 1) {
                    $('[name="url"]').addClass('is-invalid');
                    $('.invalid-url').text("{{ translate('The file should be less than 100mb.') }}");
                    flag = false;
                }

                if (document.getElementById("upload_file").files[0].size >= 209924915.2 && radioValue == 0) {

                    $('[name="url"]').addClass('is-invalid');
                    $('.invalid-url').text("{{ translate('The file should be less than 200mb.') }}");
                    flag = false;
                }

            }

            return flag;
        }

        function uploadFile(uploadFileName, status) {
            getSignedUrl(uploadFileName, function(data) {
                if (data.status == "success") {
                    $("input,select, option").attr('disabled', 'disabled');
                    $("#addVideoButton").attr("disabled", "disabled");
                    $(".uploadProgress").removeClass("d-none");
                    $("#videoUploadMsg").addClass("d-none");

                    let signedUrl = data.url;
                    let fileName = data.fileName;
                    let file = document.getElementById("upload_file").files[0];
                    let xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4) {
                            if (xhr.status === 200) {
                                let titleHide = fileName.split(".")[0];
                                $("#title_hide").val(titleHide);
                                $("#upload_file").val("");
                                $("#upload_file").removeAttr("required");
                                $("input,select, option").removeAttr('disabled');
                                if (status)
                                    $("#Formid").submit();
                                else
                                    S3RemoveFile();
                            } else {
                                $("#videoUploadMsg").removeClass("d-none");
                                $("#addVideoButton").removeAttr("disabled");
                                $(".uploadProgress").addClass("d-none");
                            }
                        }
                    };
                    xhr.upload.onprogress = function(e) {
                        if (e.lengthComputable) {
                            var percentComplete = parseInt((e.loaded / file.size) * 100);
                            $(".prepareUpload").addClass("d-none");
                            $(".uploading").removeClass("d-none");

                            $(".uploadProgress .progress-bar").css("width", percentComplete + "%");
                            $(".uploadProgress span").text("{{ translate('Uploading') }}.... " +
                                percentComplete +
                                "%");
                        }
                    };
                    xhr.open("PUT", signedUrl);
                    xhr.send(file);
                } else {
                    $("#videoUploadMsg").removeClass("d-none");
                    $("#addVideoButton").removeAttr("disabled");
                    $(".uploadProgress").addClass("d-none");
                }
            });
        }

        function S3RemoveFile() {
            var old_file_name = $('[name="old_url"]').val();

            $.ajax({
                url: '/system/remove-s3-file',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: 'POST',
                data: {
                    fileName: old_file_name
                },
                success: function(data) {
                    $("#Formid").submit();
                    return true;
                },
                async: false,
                error: function(error) {
                    return true;
                }
            });
        }


    });

</script>
