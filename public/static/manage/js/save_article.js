$(function () {
    layui.config({
        base: '/static/ac/lib/layui/inputtag/',
    }).use(['inputTags'], function () {
        var inputTags = layui.inputTags;
        inputTags.render({
            elem: '#inputTags', //定义输入框input对象
            content: HB_TAGS, //默认标签
            done: function (value) { //回车后的回调
                // HB_TAGS.push(value)
            }
        })
    });
    var tinyID = 'post_content';
    tinymce.init({
        selector: '#' + tinyID,
        language: 'zh_CN',
        menubar: false,
        branding: false,
        plugins: 'formatpainter image ',
        toolbar1: 'code undo redo | formatpainter removeformat | fontsizeselect forecolor backcolor bold italic underline strikethrough',
        toolbar2: 'alignleft aligncenter alignright alignjustify | image ',
        width: 578,
        height: 650, //编辑器高度
        min_height: 400,
        fontsize_formats: '12px 14px 16px 18px 24px 36px 48px 56px 72px',
        image_dimensions: false,
        convert_urls: false,
        image_uploadtab: true,
        automatic_uploads: true,
        images_upload_handler: function (blobInfo, success, failure) {
            var xhr, formData;

            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', HB_UPLOAD_URL);

            xhr.onload = function () {
                var json;
                if (xhr.status != 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }
                console.log(JSON.parse(xhr.responseText))
                json = JSON.parse(xhr.responseText);
                if (!json || typeof json.code != 'number') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }
                success(json.data.file_url);
            };
            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            formData.append('file_type', 'image');
            formData.append('folder', 'article');
            formData.append('_token', CSRF_TOKEN);
            xhr.send(formData);
        },
        autosave_ask_before_unload: false,
    });
    function getContent(){
        return tinyMCE.editors[tinyID].getContent();
    }
    layui.use(['form', 'upload'], function () {
        var form = layui.form, upload = layui.upload, repeat_flag = false;//防重复标识
        //普通图片上传
        upload.render({
            elem: '#imgUploadCover',
            url: HB_UPLOAD_URL,
            data: {
                file_type: 'image',
                folder: 'article',
                _token: CSRF_TOKEN
            },
            done: function (res) {
                console.log(res)
                if (res.code === 200) {
                    $("#imgUploadCover").html("<img src=" + res.data.file_url + " >");
                    $("input[name='post_pic']").val(res.data.file_path);
                }
                return layer.msg(res.message);
            }
        });
        //自定义验证规则
        form.verify({
            title: function (value) {
                if (value.length < 5) {
                    return '内容标题至少得5个字符啊~';
                }
            },
            channel: function (value) {
                if (parseInt(value) <= 1) {
                    return '请选择内容所在栏目'
                }
            },
            post_pic: function (value) {
                if (value.length < 1) {
                    return '请上传内容封面图';
                }
            },
            post_desc: function (value) {
                if (value.length < 20) {
                    return '内容描述至少得20个字符~'
                }
            },
            post_content: function (value) {
                var content = getContent();
                if (content.length < 1) {
                    return '请填写详细内容~';
                }
            }
        });
        form.on('submit(save)', function (data) {
            data.field.post_tags = HB_TAGS;
            data.field.content = getContent();
            if (repeat_flag) return false;
            repeat_flag = true;
            $.ajax({
                url: SAVE_URL,
                data: data.field,
                dataType: 'json',
                type: 'post',
                success: function (data) {
                    layer.msg(data.message);
                    if (data.code === 200) {
                        location.href = INDEX_URL;
                    } else {
                        repeat_flag = false;
                    }
                },error(err){
                    repeat_flag = false;
                }
            });
            return false;
        });
    })
});
