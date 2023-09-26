const Toast = Swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener("mouseenter", Swal.stopTimer);
    toast.addEventListener("mouseleave", Swal.resumeTimer);
  },
});

$(document).ready(function () {
  let id_seance;
  var table = $("#datatables_gestion_seances").DataTable({
    lengthMenu: [
      [10, 15, 25, 50, 100, 20000000000000],
      [10, 15, 25, 50, 100, "All"],
    ],
    order: [[0, "desc"]],
    ajax: "/assiduite/traitement/list",
    processing: true,
    serverSide: true,
    deferRender: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json",
    },
    preDrawCallback: function(settings) {
        if ($.fn.DataTable.isDataTable('#datatables_gestion_seances')) {
            var dt = $('#datatables_gestion_seances').DataTable();

            //Abort previous ajax request if it is still in process.
            var settings = dt.settings();
            if (settings[0].jqXHR) {
                settings[0].jqXHR.abort();
            }
        }
    },
    drawCallback: function () {
        $("body tr#" + id_seance).addClass('active_databales');
    },
    "columnDefs": [
            {
                "targets": [11], // The column index you want to hide (zero-based index)
                "visible": false, // Hide the column
                "searchable": false // Exclude the column from search
            }
        ]
  });
  $("select").select2();
  $("body").on("click", "#datatables_gestion_seances tbody tr", async function () {
    // const input = $(this).find("input");

    if ($(this).hasClass("active_databales")) {
      $(this).removeClass("active_databales");
      id_seance = null;
      $("body .small-box").removeClass("active");
    } else {
      $("#datatables_gestion_seances tbody tr").removeClass("active_databales");
      $(this).addClass("active_databales");
      id_seance = $(this).attr("id");
      try {
        $("body .small-box").removeClass("active");
        const request = await axios.post("/assiduite/traitement/count/" + id_seance);
        const response = request.data;
        console.log(response.data['A'])
        $("body .a").find(".number").text(response.data["A"]);
        $("body .b").find(".number").text(response.data["B"]);
        $("body .c").find(".number").text(response.data["C"]);
        $("body .d").find(".number").text(response.data["D"]);
        $("body .small-box").addClass("active");
      } catch (error) {
        console.log(error, error.response);
        const message = error.response.data;
        Toast.fire({
          icon: "error",
          title: message,
        });
        // icon.addClass("fa-edit").removeClass("fa-spinner fa-spin ");
      }
    }
    
  });

  $("body").on("dblclick", "#datatables_gestion_seances tbody tr", async function () {

      id_seance = $(this).attr("id");
      try {
        const request = await axios.get('/assiduite/traitement/etudiants/'+id_seance);
        const response = request.data;
        
        $('#etudiant_datatable').html(response.html);
        
        if ($.fn.DataTable.isDataTable("body #etudiant_datatable")) {
          $("body #etudiant_datatable").DataTable().clear().destroy();
        }
        
        $("#modal-etudiant").modal("show");
        $("body #etudiant_datatable").DataTable({
          language: {
            url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json",
          },
        });
    } catch (error) {
        console.log(error, error.response);
        const message = error.response.data.error;
        Toast.fire({
            icon: 'error',
            title: message,
        })
    }
  });

  // $("body").on("click", "#etudiant_datatable tbody tr", async function () {
  //   // const input = $(this).find("input");

  //   if ($(this).hasClass("active_databales")) {
  //     $(this).removeClass("active_databales");
  //     id_etudiant = null;
  //     $("body .small-box").removeClass("active");
  //   } else {
  //     $("#etudiant_datatable tbody tr").removeClass("active_databales");
  //     $(this).addClass("active_databales");
  //     id_seance = $(this).attr("id");
  //     try {
  //       $("body .small-box").removeClass("active");
  //       const request = await axios.post("/assiduite/traitement/count/" + id_seance);
  //       const response = request.data;
  //       console.log(response.data['A'])
  //       $("body .a").find(".number").text(response.data["A"]);
  //       $("body .b").find(".number").text(response.data["B"]);
  //       $("body .c").find(".number").text(response.data["C"]);
  //       $("body .d").find(".number").text(response.data["D"]);
  //       $("body .small-box").addClass("active");
  //     } catch (error) {
  //       console.log(error, error.response);
  //       const message = error.response.data;
  //       Toast.fire({
  //         icon: "error",
  //         title: message,
  //       });
  //       // icon.addClass("fa-edit").removeClass("fa-spinner fa-spin ");
  //     }
  //   }
    
  // });

  $("body").on("dblclick", "#etudiant_datatable tbody tr", async function () {

    admission = $(this).attr("admission");
    try {
      const request = await axios.get('/assiduite/traitement/etudiant_details/'+admission);
      const response = request.data;
      
      $("##modal-detail-etudiant #edit_etudiant").html(response);    

      
      $("#modal-detail-etudiant").modal("show");
  } catch (error) {
      console.log(error, error.response);
      const message = error.response.data.error;
      Toast.fire({
          icon: 'error',
          title: message,
      })
  }
});

  $("#day").on("change", async function () {
    const day = $(this).val();
    if (day || day != "") {
      table.columns(0).search($(this).val()).draw();
    } else {
      table.columns(0).search("").draw();
    }
  });
  $("#etablissement").on("change", async function () {
    const id_etab = $(this).val();
    let response = "";
    if (id_etab != "") {
      const request = await axios.get("/api/formation/" + id_etab);
      response = request.data;
      table.columns(1).search($(this).val()).draw();
    } else {
      table.columns(1).search("").draw();
    }
    $("#formation").html(response).select2();
  });
  $("#formation").on("change", async function () {
    const id_formation = $(this).val();
    let response = "";
    // alert(id_formation);
    if (id_formation != "") {
      table.columns(2).search(id_formation).draw();
      const request = await axios.get("/api/promotion/" + id_formation);
      response = request.data;
    } else {
      table.columns(2).search("").draw();
    }
    $("#promotion").html(response).select2();
  });
  $("#promotion").on("change", async function () {
    const id_promotion = $(this).val();

    if (id_promotion != "") {
      table.columns(3).search(id_promotion).draw();
      //   const request = await axios.get("/api/semestre/" + id_promotion);
      //   response = request.data;
    } else {
      table.columns(3).search("").draw();
    }
    // $("#semestre").html(response).select2();
  });
  
  $("#modifiersalle").on("click", async () => {
      // alert($("#formation").val())
    var salle = $("#salles").val();
    if(!id_seance){
      Toast.fire({
        icon: 'error',
        title: 'Veuillez choissir une séance!',
      })
      return;
    }
    if(!salle){
        Toast.fire({
          icon: 'error',
          title: 'Veuillez choissir une salle!',
        })
        return;
    }
      
    const icon = $("#modifiersalle i");

    try {
        icon.remove('fa-edit').addClass("fa-spinner fa-spin ");
        const request = await axios.get('/assiduite/traitement/modifiersalle/'+id_seance+'/'+salle);
        const response = request.data;
        console.log(response);
        Toast.fire({
          icon: 'success',
          title: 'La salle est bien modifiée!',
        })
        icon.addClass('fa-edit').removeClass("fa-spinner fa-spin ");
        table.ajax.reload();
    } catch (error) {
        console.log(error, error.response);
        const message = error.response.data;
        Toast.fire({
            icon: 'error',
            title: message,
          })
        icon.addClass('fa-edit').removeClass("fa-spinner fa-spin ");
    }

  })

  $("#traiter").on("click", async function () {
    if (!id_seance) {
      Toast.fire({
        icon: "error",
        title: "Veuillez selectioner une ligne!",
      });
      return;
    }
    const icon = $("#traiter i");
    // alert(id_seance)
    // var res = confirm('Vous voulez vraiment traiter cette seance ?');
    // if(res == 1){
    try {
      $("body .small-box").removeClass("active");
      icon.remove("fa-edit").addClass("fa-spinner fa-spin ");
      const request = await axios.post("/assiduite/traitement/traiter/" + id_seance + "/1");
      const response = request.data;
      table.ajax.reload();
    //   id_seance = false
      icon.addClass("fa-edit").removeClass("fa-spinner fa-spin ");
      Toast.fire({
        icon: "success",
        title: response.message,
      });
      // console.log(response.data['A'])
      $("body .a").find(".number").text(response.data["A"]);
      $("body .b").find(".number").text(response.data["B"]);
      $("body .c").find(".number").text(response.data["C"]);
      $("body .d").find(".number").text(response.data["D"]);
      $("body .small-box").addClass("active");
    } catch (error) {
      console.log(error, error.response);
      const message = error.response.data;
      Toast.fire({
        icon: "error",
        title: message,
      });
      icon.addClass("fa-edit").removeClass("fa-spinner fa-spin ");
    }
    // }
  });

  $("#retraiter").on("click", async function () {
    if (!id_seance) {
      Toast.fire({
        icon: "error",
        title: "Veuillez selectioner une ligne!",
      });
      return;
    }
    const icon = $("#retraiter i");
    // alert(id_seance)
    var res = confirm('Vous voulez vraiment retraiter cette seance ?');
    if(res == 1){
      try {
        $("body .small-box").removeClass("active");
        icon.remove("fa-edit").addClass("fa-spinner fa-spin ");
        const request = await axios.post("/assiduite/traitement/traiter/" + id_seance + "/2");
        const response = request.data;
        table.ajax.reload();
      //   id_seance = false
        icon.addClass("fa-edit").removeClass("fa-spinner fa-spin ");
        Toast.fire({
          icon: "success",
          title: response.message,
        });
        // console.log(response.data['A'])
        $("body .a").find(".number").text(response.data["A"]);
        $("body .b").find(".number").text(response.data["B"]);
        $("body .c").find(".number").text(response.data["C"]);
        $("body .d").find(".number").text(response.data["D"]);
        $("body .small-box").addClass("active");
      } catch (error) {
        console.log(error, error.response);
        const message = error.response.data.error;
        Toast.fire({
            icon: 'error',
            title: message,
        })
        icon.addClass("fa-edit").removeClass("fa-spinner fa-spin ");
      }
    }
  });

  
  $("body #parlot_search").on("click", async function (e) {
    e.preventDefault()
    var hd = $("body #hd").val();
    var hf = $("body #hf").val();
    var date = $("body #day").val();
    // var date = $("body #datetime").val();
    // console.log(hd, hf);

    if (!hd) {
      Toast.fire({
        icon: 'error',
        title: 'Veuillez remplir la date Debut !',
        });
      return;
    }
    if (!hf) {
      Toast.fire({
        icon: 'error',
        title: 'Veuillez remplir la date Fin !',
        });
      return;
    }

    const icon = $("#parlot_search i");

    try {
        icon.remove('fa-search').addClass("fa-spinner fa-spin ");
        const request = await axios.get('/assiduite/traitement/parlot/'+hd+"/"+hf+"/"+date);
        const response = request.data;

        $('body #parlot_datatable').html(response.html);

        if ($.fn.DataTable.isDataTable("body #parlot_datatable")) {
          $("body #parlot_datatable").DataTable().clear().destroy();
        }

        $("body #parlot_datatable").DataTable({
          language: {
            url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json",
          },
        });


        icon.addClass('fa-search').removeClass("fa-spinner fa-spin ");
        table.ajax.reload();
    } catch (error) {
        console.log(error, error.response);
        const message = error.response.data.error;
        Toast.fire({
            icon: 'error',
            title: message,
        })
        icon.addClass('fa-edit').removeClass("fa-spinner fa-spin ");
    }
  });
  // var seances = [];
  // $("#check").on("click", async function (e) {
  //   e.preventDefault();
    
  //   $("#parlot_datatable input[type='checkbox']").each(function () {
  //     if ($(this).is(":checked")) {
  //       seances.push($(this).attr("id"));
  //     }else {
  //       $(this).prop("checked", true);
  //       seances.push($(this).attr("id"));
  //     }
  //   });
  //   console.log(seances);
  // });

  // !!!!!!! heree
  seances = [];
  $("body").on("click", "#check", function () {
    // alert('test')
    const se = $("body .check_seance");
    if ($("#check").prop("checked") == true) {
        se.prop("checked", true);
        se.map(function () {
          seances.push(this.value);
        });
        $("#check").prop("checked", false);
        // console.log(admissions);
    } else {
        se.prop("checked", false);
        seances = [];
    }
    console.log(seances);
  });

  $("#reinitialiser").on("click", async () => {
    if(!id_seance){
      Toast.fire({
        icon: 'error',
        title: 'Veuillez choissir une séance!',
      })
      return;
    }
    var confirmation = confirm("Voulez-vous vraiment reinitialiser cette seance!");
    if (confirmation) {
      const icon = $("#reinitialiser i");

      try {
          icon.remove('fa-minus').addClass("fa-spinner fa-spin ");
          const request = await axios.get('/assiduite/traitement/reinitialiser/'+id_seance);
          const response = request.data;
          console.log(response);
          Toast.fire({
            icon: 'success',
            title: 'La seance est bien reinitialiser!',
          })
          icon.addClass('fa-minus').removeClass("fa-spinner fa-spin ");
          table.ajax.reload();
      } catch (error) {
          console.log(error, error.response);
          const message = error.response.data.error;
        Toast.fire({
            icon: 'error',
            title: message,
        })
          icon.addClass('fa-minus').removeClass("fa-spinner fa-spin ");
      }
    }

  })

  $("#signer").on("click", async () => {
    if(!id_seance){
      Toast.fire({
        icon: 'error',
        title: 'Veuillez choissir une séance!',
      })
      return;
    }
    const icon = $("#signer i");
  
    try {
        icon.remove('fa-signature').addClass("fa-spinner fa-spin ");
        const request = await axios.get('/assiduite/traitement/signer/'+id_seance);
        const response = request.data;
        console.log(response);
        Toast.fire({
          icon: 'success',
          title: 'La seance est signée!',
        })
        icon.addClass('fa-signature').removeClass("fa-spinner fa-spin ");
        table.ajax.reload();
    } catch (error) {
        console.log(error, error.response);
        const message = error.response.data.error;
        Toast.fire({
            icon: 'error',
            title: message,
        })
        icon.addClass('fa-signature').removeClass("fa-spinner fa-spin ");
    }
  
  })

  $("#existe").on("click", async () => {
    if(!id_seance){
      Toast.fire({
        icon: 'error',
        title: 'Veuillez choissir une séance!',
      })
      return;
    }
    const icon = $("#existe i");
  
    try {
        icon.remove('fa-thumbtack').addClass("fa-spinner fa-spin ");
        const request = await axios.get('/assiduite/traitement/existe/'+id_seance);
        const response = request.data;
        console.log(response);
        Toast.fire({
          icon: 'success',
          title: 'La seance existe!',
        })
        icon.addClass('fa-thumbtack').removeClass("fa-spinner fa-spin ");
        table.ajax.reload();
    } catch (error) {
        console.log(error, error.response);
        const message = error.response.data.error;
        Toast.fire({
            icon: 'error',
            title: message,
        })
        icon.addClass('fa-thumbtack').removeClass("fa-spinner fa-spin ");
    }
  
  })

  $("#verouiller").on("click", async () => {
    if(!id_seance){
      Toast.fire({
        icon: 'error',
        title: 'Veuillez choissir une séance!',
      })
      return;
    }
    var confirmation = confirm("Voulez-vous vraiment verouiller cette seance!");
    if (confirmation) {
      const icon = $("#verouiller i");
  
      try {
          icon.remove('fa-lock').addClass("fa-spinner fa-spin ");
          const request = await axios.get('/assiduite/traitement/verouiller/'+id_seance);
          const response = request.data;
          console.log(response);
          Toast.fire({
            icon: 'success',
            title: 'La seance est bien verouillée!',
          })
          icon.addClass('fa-lock').removeClass("fa-spinner fa-spin ");
          table.ajax.reload();
      } catch (error) {
          console.log(error, error.response);
          const message = error.response.data.error;
        Toast.fire({
            icon: 'error',
            title: message,
        })
          icon.addClass('fa-lock').removeClass("fa-spinner fa-spin ");
      }
    }
  })

  $("#annuler").on("click", async () => {
    if(!id_seance){
      Toast.fire({
        icon: 'error',
        title: 'Veuillez choissir une séance!',
      })
      return;
    }
    var confirmation = confirm("Voulez-vous vraiment annuler cette seance!");
    if (confirmation) {
      const icon = $("#existe i");
  
      try {
          icon.remove('fa-window-close').addClass("fa-spinner fa-spin ");
          const request = await axios.get('/assiduite/traitement/annuler/'+id_seance);
          const response = request.data;
          console.log(response);
          Toast.fire({
            icon: 'success',
            title: 'La seance est bien annulée!',
          })
          icon.addClass('fa-window-close').removeClass("fa-spinner fa-spin ");
          table.ajax.reload();
      } catch (error) {
          console.log(error.response.data);
          const message = error.response.data.error;
        Toast.fire({
            icon: 'error',
            title: message,
        })
          icon.addClass('fa-window-close').removeClass("fa-spinner fa-spin ");
      }
    }
  })

  $("#scan").on("click", async () => {
    if(!id_seance){
      Toast.fire({
        icon: 'error',
        title: 'Veuillez choissir une séance!',
      })
      return;
    }
    window.open(
      "/assiduite/traitement/open/"+id_seance,
      "_blank"
    );
  
  })

  $("#imprimer").on("click", async () => {
    if(!id_seance){
      Toast.fire({
        icon: 'error',
        title: 'Veuillez choissir une séance!',
      })
      return;
    }
    window.open(
      "/assiduite/traitement/imprimer/"+id_seance,
      "_blank"
    );
  
  })

  $("#z").on("click", async () => {
    if(!id_seance){
      Toast.fire({
        icon: 'error',
        title: 'Veuillez choissir une séance!',
      })
      return;
    }
    const icon = $("#z i");

    try {
        icon.remove('fa-edit').addClass("fa-spinner fa-spin ");
        const request = await axios.get('/assiduite/traitement/z/'+id_seance);
        const response = request.data;
        console.log(response);
        Toast.fire({
          icon: 'success',
          title: 'les catégories sont changées en Z!',
        })
        icon.addClass('fa-edit').removeClass("fa-spinner fa-spin ");
        table.ajax.reload();
    } catch (error) {
        console.log(error.response.data);
        const message = error.response.data.error;
        Toast.fire({
            icon: 'error',
            title: message,
          })
        icon.addClass('fa-edit').removeClass("fa-spinner fa-spin ");
    }
  })

  $("#s").on("click", async () => {
    if(!id_seance){
      Toast.fire({
        icon: 'error',
        title: 'Veuillez choissir une séance!',
      })
      return;
    }
    const icon = $("#s i");

    try {
        icon.remove('fa-edit').addClass("fa-spinner fa-spin ");
        const request = await axios.get('/assiduite/traitement/s/'+id_seance);
        const response = request.data;
        console.log(response);
        Toast.fire({
          icon: 'success',
          title: 'les catégories sont changées en S!',
        })
        icon.addClass('fa-edit').removeClass("fa-spinner fa-spin ");
        table.ajax.reload();
    } catch (error) {
        console.log(error.response.data);
        const message = error.response.data.error;
        Toast.fire({
            icon: 'error',
            title: message,
          })
        icon.addClass('fa-edit').removeClass("fa-spinner fa-spin ");
    }
  })

  $('body').on('click', '#planing', function(e){
    e.preventDefault();
    var today = $("body #day").val();
    if(!today) {
        Toast.fire({
            icon: 'error',
            title: 'Veuillez selection une date!',
        })
        return;
    }
    window.open('/assiduite/traitement/planing/'+today, '_blank');
})

});
