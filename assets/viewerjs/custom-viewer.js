  // $.fn.viewer.noConflict();


function initializeViewer() {
	$(".viewer_image").viewer({backdrop: 'static'});
	$(".viewer_images").viewer({backdrop: 'static'});
}

 function viewerImageSingle(event) {
 	// var viewer=$(event).viewer();
 //	console.log($(event));
 	var singleOptions= {
 		inline: false,
  		viewed: function() {
  			console.log((typeof this.viewer));
  		}
	};
	$(event).viewer(singleOptions);
 
 }

  function viewerImageMultiple(event) {
 	$(event).viewer();
 }