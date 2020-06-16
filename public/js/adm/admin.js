$(document).ready(function(){
    $(function () {
// add delete confirmation
        $(".delete_with_icon").click(function () {return confirm('Are you SURE you want to delete this') });
    });
});
// ------------------------------------------------------- //
// Custom Scrollbar
// ------------------------------------------------------ //
$(document).ready(function () {

    if ($(window).outerWidth() > 992) {
        $("nav.side-navbar").mCustomScrollbar({
            scrollInertia: 200
        });
    }

// Main Template Color
    var brandPrimary = '#33b35a';

// ------------------------------------------------------- //
// Side Navbar Functionality
// ------------------------------------------------------ //
    $('#toggle-btn').on('click', function (e) {

        e.preventDefault();

        if ($(window).outerWidth() > 1194) {
            $('nav.side-navbar').toggleClass('shrink');
            $('.page').toggleClass('active');
        } else {
            $('nav.side-navbar').toggleClass('show-sm');
            $('.page').toggleClass('active-sm');
        }
    });

});


$(document).ready(function () {

    tinymce.init({
        selector: "textarea.addTinymce",
        content_style: ".mce-content-body {font-size:14px;font-family:Arial,sans-serif;}",
        force_br_newlines : true,
        force_p_newlines : false,
        autosave_ask_before_unload: true,
        autosave_restore_when_empty: true,
        forced_root_block : '',
        convert_urls : false,
        autosave_interval: "20s",
        image_dimensions: false,
        object_resizing : false,
        browser_spellcheck: true,
        contextmenu: false,
        mobile: {
            menubar: true
        },
        height: "400",
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen autosave',
            'insertdatetime media nonbreaking save table directionality template',
            'emoticons template paste textpattern imagetools image'
        ],
        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
        toolbar2: 'link image, | restoredraft, | print preview media | forecolor backcolor emoticons template insert',

        //templates: "public/WebVersionEmail.php",
        templates:
            [
                {title: 'Single News', description: '', url: '/templates/WebVersionEmailSingleNews.php'},
                {title: 'Box colunm with body images', description: '', url: '/templates/base_boxed_body_image_2column.php'},
                {title: 'Plain Text', description: '', url: '/templates/WebVersionEmailPlainText.php'},
                {title: 'Multiple News', description: '', url: '/templates/WebVersionEmailMultipleNews.php'},
                {title: 'Big News', description: '', url: '/templates/WebVersionEmailFewBigNews.php'},
                {title: 'Blog Stories', description: '', url: '/templates/WebVersionEmailBlogStories.php'},
                {title: 'Email Footer', description: '', url: '/templates/WebVersionEmailFooter.php'}
            ],

        style_formats: [
            { title: 'Bold text', inline: 'strong' },
            { title: 'Blue text', inline: 'span', styles: { color: '#2276d2' } },
            { title: 'Blue header', block: 'h2', styles: { color: '#2276d2' } },
            { title: 'Badge', inline: 'span', styles: { display: 'inline-block', border: '1px solid #2276d2', 'border-radius': '5px', padding: '2px 5px', margin: '0 2px', color: '#2276d2' } },
            { title: 'Table row 1', selector: 'tr', classes: 'tablerow1' }
        ],
        formats: {
            alignleft: { selector: 'p,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'left' },
            aligncenter: { selector: 'p,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'center' },
            alignright: { selector: 'p,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'right' },
            alignfull: { selector: 'p,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'full' },
            bold: { inline: 'span', 'classes': 'bold' },
            italic: { inline: 'span', 'classes': 'italic' },
            underline: { inline: 'span', 'classes': 'underline', exact: true },
            strikethrough: { inline: 'del' },
            customformat: { inline: 'span', styles: { color: '#00ff00', fontSize: '20px' }, attributes: { title: 'My custom format' }, classes: 'example1' },
        },
        image_class_list: [
            {title: 'Responsive', value: 'img-fluid'}
        ],
        // enable title field in the Image dialog
        image_title: true,
        // enable automatic uploads of images represented by blob or data URIs
        automatic_uploads: true,
        images_reuse_filename: false,
        // URL of our upload handler (for more details check: https://www.tinymce.com/docs/configure/file-image-upload/#images_upload_url)
        images_upload_url: '/upload.php',
        images_upload_base_path: '/storyImg/posts',
        // here we add custom filepicker only to Image dialog
        file_picker_types: 'image',
        // and here's our custom image picker
        image_advtab: true,
        file_picker_callback: function(cb, value, meta) {
            let input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            // Note: In modern browsers input[type="file"] is functional without
            // even adding it to the DOM, but that might not be the case in some older
            // or quirky browsers like IE, so you might want to add it to the DOM
            // just in case, and visually hide it. And do not forget do remove it
            // once you do not need it anymore.

            input.onchange = function() {
                let file = this.files[0];

                let reader = new FileReader();
                reader.onload = function () {
                    // Note: Now we need to register the blob in TinyMCEs image blob
                    // registry. In the next release this part hopefully won't be
                    // necessary, as we are looking to handle it internally.
                    let id = 'imageID' + (new Date()).getTime();
                    let blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    let base64 = reader.result.split(',')[1];
                    let blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);

                    // call the callback and populate the Title field with the file name
                    cb(blobInfo.blobUri(), { title: file.name });
                };
                reader.readAsDataURL(file);
            };

            input.click();
        },

        images_upload_handler: function (blobInfo, success, failure) {
            let xhr, formData;
            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '/upload.php');

            xhr.onload = function() {
                let json;

                if (xhr.status != 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }

                json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }

                success(json.location);

            };

            formData = new FormData();
            //let fileName =  blobInfo.blob().name;
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            //if( typeof(blobInfo.blob().name) !== undefined )
               //fileName = blobInfo.blob().name;
            //else
               //fileName = blobInfo.filename();
            //formData.append('file', blobInfo.blob(), fileName);

            xhr.send(formData);
            //tinymce.activeEditor.uploadImages(function(success) {
            // document.forms[0].submit();
            //});
        }
    });

});




$(function(){
    // check the main records
    $('#select_all').click(function(event) {
        if(this.checked) {
            // Iterate each checkbox
            $(':checkbox').each(function() {
                this.checked = true;
            });
        }
        else {
            // Iterate each checkbox
            $(':checkbox').each(function() {
                this.checked = false;
            });
        }
    });
});


// Check the gallery
$(function(){

    $('#gallery_all').click(function(event) {
        if(this.checked) {
            // Iterate each checkbox
            $(':checkbox').each(function() {
                this.checked = true;
            });
        }
        else {
            // Iterate each checkbox
            $(':checkbox').each(function() {
                this.checked = false;
            });
        }
    });
});
