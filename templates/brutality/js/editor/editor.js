/*
 * Редактор
 * */
tinymce.init({
	selector: ".editor",
	relative_urls:false,
	language : 'ru',
	//plugins : 'advlist autolink link image media lists charmap print preview responsivefilemanager, code, hr, fullscreen',
	plugins : 'advlist autolink link image media lists charmap print preview, code, hr, fullscreen',
	content_css : "templates/brutality/css/bootstrap.min.css",
	toolbar: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect | tools | link unlink anchor | image | forecolor backcolor  | fullscreen",
	image_advtab: true

//		external_filemanager_path:"/ci/filemanager/",
//		filemanager_title:"Менеджер файлов" ,
//		external_plugins: { "filemanager" : "../../../filemanager/plugin.min.js"}
});