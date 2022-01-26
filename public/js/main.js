// $(document).ready(function () {
	
//  // Images Coursel 
//   // Instantiate the Bootstrap carousel
//   $('.carousel').carousel({
//     interval: false
//   });

// // // for every slide in carousel, copy the next slide's item in the slide.
// // // Do the same for the next, next item.
// $('.multi-item-carousel .carousel-item').each(function(){
//   // var next = $(this).next(); // Get the next Item
  
//   // if (!next.length) { // If Last item, next will be the first item
//   //   next = $(this).siblings(':first');
//   // }

//   // // Add second child from the next element 
//   // next.children(':first-child').clone().appendTo($(this)); 
  

//   // // Add third child from the next of the next element
//   // if (next.next().length>0) {
//   //   next.next().children(':first-child').clone().appendTo($(this));
//   // } else {
//   // 	$(this).siblings(':first').children(':first-child').clone().appendTo($(this));
//   // }
// });

//   window._token = $('meta[name="csrf-token"]').attr('content')

//   var allEditors = document.querySelectorAll('.ckeditor');
//   for (var i = 0; i < allEditors.length; ++i) {
//     ClassicEditor.create(
//         allEditors[i],
//         {
//             removePlugins: ['ImageUpload']
//         }
//     );
//   }

//   moment.updateLocale('en', {
//     week: {dow: 1} // Monday is the first day of the week
//   })

//   $('.date').datetimepicker({
//     format: 'YYYY-MM-DD',
//     locale: 'en'
//   })

//   $('.datetime').datetimepicker({
//     format: 'YYYY-MM-DD HH:mm:ss',
//     locale: 'en',
//     sideBySide: true
//   })

//   $('.timepicker').datetimepicker({
//     format: 'HH:mm:ss'
//   })

//   $('.select-all').click(function () {
//     let $select2 = $(this).parent().siblings('.select2')
//     $select2.find('option').prop('selected', 'selected')
//     $select2.trigger('change')
//   })
//   $('.deselect-all').click(function () {
//     let $select2 = $(this).parent().siblings('.select2')
//     $select2.find('option').prop('selected', '')
//     $select2.trigger('change')
//   })

//   $('.select2').select2()

//   $('.treeview').each(function () {
//     var shouldExpand = false
//     $(this).find('li').each(function () {
//       if ($(this).hasClass('active')) {
//         shouldExpand = true
//       }
//     })
//     if (shouldExpand) {
//       $(this).addClass('active')
//     }
//   })

// })
