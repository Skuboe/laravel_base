/**
 * 編集 または 削除ボタン押下時のイベント処理
 */
$('.form-btn').click(function() {

    const id = $(this).data('id');
    const title = $(this).data('title');
    const contents = $(this).data('contents');
    const weather_id = $(this).data('weather_id');

    $('.modal-diaries-title').text(title).val(title);
    $('.modal-diaries-contents').text(contents).val(contents);

    $('#modal-edit #edit_title').val(title);
    $('#modal-edit #edit_contents').val(contents);
    $('#modal-edit #edit_diaries_id').val(id);
    $('#modal-edit #edit_weather_id').val(weather_id);

    $('#modal-delete #delete_diaries_id').val(id);

});

/**
 * 編集ボタン押下時のイベント処理
 */
$(document).on("click", "#modal-edit #editBtn", function(event) {
    //通常のアクションをキャンセルする
    //event.preventDefault();

    //formセレクタを取得
    let form = $('#modal-edit').get(0);
    //FormData オブジェクトを作成
    let formData = new FormData(form);

    $.ajax({
        url: '/edit',
        type: "post",
        data: formData,
        processData: false, //ajaxがdataを整形しない指定
        contentType: false, //contentTypeもfalseに指定
    }).done(function(result, textStatus, jqXHR){
        // エラーメッセージ個所を一括非表示
        $('[id^=error_]').hide();

        ret = result[0];
        if (ret.success) {
            $('#editModalCenter').modal('hide');
            location.href = "/diary";
        } else {
            var messageBags = ret.errors;
            jQuery.each(messageBags, function(key, value) {
                var fieldName = key;
                var errorMessages = value;
                // 一致する個所にエラーメッセージを埋め込み表示する
                jQuery.each(errorMessages, function(msgID, msgContent) {
                    $('#error_edit_' + fieldName).html(msgContent);
                    $('#error_edit_' + fieldName).show();
                });
            });

        }
    }).fail(function(result, textStatus, jqXHR){
        $('#btnProfileUpdate').attr('disabled', false);
        console.debug(result);
    });

    return false;
});
