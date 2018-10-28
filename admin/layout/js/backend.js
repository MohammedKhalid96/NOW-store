$(function() {
    
    'use strict';
    //trigger the selectboxit 
     $("select").selectBoxIt({
         autoWidth:false
     });
    
    
    //hide placeholder
$('[placeholder]').focus(function() {
    
    $(this).attr('data-text',$(this).attr('placeholder'));
    $(this).attr('placeholder','');
})

    .blur(function() {
        
        $(this).attr('placeholder',$(this).attr('data-text'));
    });
    

    //confirmation Message on button
    $('.confirm').click(function() {
        return confirm('Are You Sure?'); 
    });
    
});

$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#example tfoot td').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#example').DataTable();
 
    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
} );