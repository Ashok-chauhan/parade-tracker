function backReset(routeid){

    if (confirm('Are you sure you want to reset back of parade location?')) {
        // Save it!
        console.log('Thing was saved to the database.', routeid);
       window.location = '/home/resetTail/'+routeid;
      } else {
         console.log('Canceled.');
      }
}

function headReset(routeid){

    if (confirm('Are you sure you want to reset head of parade location?')) {
        // Save it!
        console.log('Thing was saved to the database.', routeid);
       window.location = '/home/resetHead/'+routeid;
      } else {
         console.log('Canceled.');
      }
}

