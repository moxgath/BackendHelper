function loader(text) {
	destroy_loader();
	$('body').prepend('<div class="ikr-loader"><div class="ikr-loader-box"></div></div>');
	$('body').addClass('loading');
	$('#b-c-facebook').css('z-index', $('#b-c-facebook').css('z-index'));
	var imgUrl = baseUrl + '/assets/frontend/images/loading.gif';
	$('.ikr-loader .ikr-loader-box').html('<img src="'+imgUrl+'"><p>'+text+'</p>');
}

function destroy_loader() {
	$('body div.ikr-loader').remove();
	$('body').removeClass('loading');
}

$.fn._summernote = function(config) {
	var $summernote = $(this);

	if(typeof summernoteUploadUrl !== 'undefined' &&
		typeof summernoteToken !== 'undefined') {
		var imageUpload = {
			callbacks: {
				onImageUpload: function(files) {
			      if(files.length > 5) {
			    		toastr.error('อัพโหลดได้สูงสุดครั้งละ 5 รูป/ครั้ง');
			    		return;
			    	}
			      	var data = new FormData();
			      	$.each(files, function(index, file) {
			      		data.append("files[]", file);
			      	});
			      	data.append("_token", summernoteToken);
			      	
			      	loader('กำลังอัพโหลดรูปภาพ จำนวน ' + files.length + ' รูป');

			      	$.ajax({
			      		url: summernoteUploadUrl,
			      		method: "POST",
			      		data: data,
		                cache: false,
		                contentType: false,
		                processData: false,
			      		success: function(urlList) {
			      			$.each(urlList, function(index, url) {
		                    	$summernote.summernote("insertImage", url, function($image) {
		                    		$image.css('width', '100%');
		                    	});
			      			});
			      			toastr.success('อัพโหลดรูปภาพแล้ว');
		                },
		                error: function() {
		                	toastr.error('อัพโหลดรูปภาพล้มเหลว');
		                },
		                complete: function() {
		                	destroy_loader();
		                }
			      	})
			    }
			}
		}
		$.extend(config, imageUpload);
	}

	$summernote.summernote(config);

//----------------------------------------
	var limit = $summernote.attr('maxlength');

	if(limit) {
    	var num = $summernote.summernote('code').replace(/(<([^>]+)>)/ig,"").length;
    	$('#summernote-limit').html(num+'/'+limit);

		$summernote.on('summernote.keyup', function(we, e) {
	        var num = $summernote.summernote('code').replace(/(<([^>]+)>)/ig,"").length;
	        $('#summernote-limit').html(num+'/'+limit);
	        if (num < limit){
	        	$('#summernote-limit').removeClass('label-danger').addClass('label-success');
	        } else {
	            $('#summernote-limit').removeClass('label-success').addClass('label-danger');
	        }
		});

		$summernote.on('summernote.keydown', function(we, e) {
	        var num = $summernote.summernote('code').replace(/(<([^>]+)>)/ig,"").length;
            var key = e.keyCode;
            allowed_keys = [8, 37, 38, 39, 40, 46]
            if($.inArray(key, allowed_keys) != -1)
                return true
            else if(num >= limit){
                e.preventDefault();
                e.stopPropagation()
            }
		});
	}
};

$(document).ready(function() {
	$('a[data-toggle="close-ads"]').click(function() {
		var align = $(this).data('align');
		$('div.sidebar-a.a-' + align).fadeOut(function() {
			$(this).remove();
		});
	});
});