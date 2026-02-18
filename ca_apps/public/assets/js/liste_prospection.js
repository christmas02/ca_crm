
        $(document).on('click','#massaffectation', function(e){
            $('.checkboxOpp').each(function() {
                 if(this.checked) {
                    console.log($(this).val())
                 }
            
            })

        })



            // $('#buttons-datatables').dataTable({
            //     // "autoWidth": false,
            //     // "lengthChange": false,
            //     "destroy": true,
            //     "pageLength": 25
            // });

        // $('#buttons-datatables').dataTable({
        //         // "autoWidth": false,
        //         // "lengthChange": false,
        //         //"destroy": true,
        //         //"pageLength": 25
        //         "lengthMenu": [0, 5, 10, 20, 50, 100],
        //     });

        
            // $('#cardtableChecker')

            $('#cardtableChecker').change(function() {
                if(this.checked) {
                     $('.checkboxOpp:visible').prop('checked', true);
                      $("#massaffectation").css("display",'block'); 
                }else{
                 $('.checkboxOpp:visible').prop('checked', false);  
                 $("#massaffectation").css("display",'none');     
                }
            });



           


            var currentOpp =0;
             $(document).on('click','.attrib_btn', function(e){
                   e.preventDefault();  
                 currentOpp = $(this).attr('data-opp');
                   
               $.ajax({
                type : "GET",
                url : '/find_available_agent',
                // data: {donnee:donnee},   
                success : function(r) {
                  $('#content_liv_pop').html(r);
                  $('#agentdispo').modal('show');
                  $('#numcom').html(currentOpp);
                }
              })
            });   



             $(document).on('click','.setliv', function(e){
                   e.preventDefault();  
                   // var numcmd = $(this).attr('data-com');
                   var id_agent = $(this).attr('data-idagent');

                         $.ajaxSetup({
                              headers: {
                                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                              }
                          });

                           $.ajax({
                            type : "POST",
                            data: {numopp:currentOpp, id_agent: id_agent},
                            url : '/attrib_opportunite',
                            // data: {donnee:donnee},   
                            success : function(r) {
                              if(r=='inserted') {
                                $('#agentdispo').modal('hide');
                                $('#successModal').modal('show');
                                setTimeout(function(){
                                   location.reload(true);
                                }, 3000);
                                
                              }
                                
                            }
                          })
              }); 




// dateecheance

    var ulrQuery='/listeprosprectionbydate/';
  
    var typefiltre = '';
    // dateecheance
         $("#submitfilter").click(function(e) {
            
            e.preventDefault();
            var hasError = false;
            var btnclicked = $(this);
            var uploadhaserror = false;
            var datasT = new FormData();
            var hasErrorupload = new Array();

            $('#filterform').find('input, textarea, select').each(function() {
                if ($(this).is(':input:file')) {
                    if ($(this).val() !== '') {
                        hasErrorupload.push(chech_uploadedfile($(this)));
                        i++;
                    }
                    datasT.append(this.name, $(this)[0].files[0]);
                } else if ($(this).is(':radio')) {
                    if ($(this).is(':checked')) {
                        datasT.append(this.name, $(this).val());
                    }
                } else {
                    datasT.append(this.name, $(this).val());
                }
            });

            $('.requiredField').addClass('fieldtrue');
            $('#filterform .requiredField:visible').each(function() {
                var i = $(this);
                i.siblings('.validate').html('');
                if (jQuery.trim($(this).val()) === '') {
                    hasError = true;
                    $(this).addClass('invalid');
                    i.siblings('.validate').html((hasError ? (i.attr('data-msg') !== undefined ? i.attr('data-msg') : 'wrong Input') : '')).show('blind');
                } else if ($(this).hasClass('email')) {
                    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                    if (!emailReg.test(jQuery.trim($(this).val()))) {
                        hasError = true;
                        $(this).addClass('invalid');
                        i.siblings('.validate').html((hasError ? (i.attr('data-msg') !== undefined ? i.attr('data-msg') : 'wrong Input') : '')).show('blind');
                    }
                }
            });

            if (!hasError) {
                
               var  inputTel = $("#telfiltre").val();
               var inputDate = $("#datefiltre").val();
 
                 console.log('aaaaaaaa ' +typefiltre);
                 if (typefiltre == 'tel') {
                
                     ulrQuery ='/listeprosprectionbytel/'+inputTel;
                         console.log(ulrQuery);
                 }

                  if (typefiltre == 'date') {
                     ulrQuery ='/listeprosprectionbydate/'+inputDate;
                         console.log(ulrQuery);
                 }


                $.ajax({
                  type: 'GET',
                 // data: datasend,
                  // contentType: false, 
                  // processData: false,
                  url: ulrQuery,
                  beforeSend: function(){
                    btnclicked.removeClass('normalstate');
                    btnclicked.addClass('is-active');
                  },
                  success: function(response){
                   // if (response =='exist') {
                   //  // var button = btnclicked;
                   //  location.href= '/listeprosprection';
                  
                   // }else if( response =='existsub'){
                   //   location.href= '/liste_prospection_byagent';
                   // }

                   // else{
                   //  $('.alert-danger').css('display','block');
                   
                   //  $("input[type=text],input[type=password], textarea").val("")
                   // }

                  }
                });
            }
         })


          $('#selectfiltre').on('change', function(e) {
               typefiltre = $(this).val();
           
              if (typefiltre == 'tel') {
                  $("#formtelfield").css('display','block');  
                  $("#formdatefield").css('display','none');   
                  //datasend ={tel:inputTel};
              }
              if (typefiltre == 'date') {
                  $("#formtelfield").css('display','none');  
                  $("#formdatefield").css('display','block'); 
              }  
          })