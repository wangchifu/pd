   function sw_confirm1(message,url) {
           Swal.fire({
               title: "操作確認",
               text: message,
               showCancelButton: true,
               confirmButtonText:"確定",
               cancelButtonText:"取消",
           }).then(function(result) {
              if (result.value) {
               window.location = url;
              }
              else {
                 return false;
              }
           });
       }
       function sw_confirm2(message,id) {
           Swal.fire({
               title: "操作確認",
               text: message,
               showCancelButton: true,
               confirmButtonText:"確定",
               cancelButtonText:"取消",
           }).then(function(result) {
              if (result.value) {
               document.getElementById(id).submit();
              }
              else {
                 return false;
              }
           });
       }
       function sw_alert(title,message,action){
         Swal.fire({
         title: title,
         text: message,
         icon: action,
           });
       }
