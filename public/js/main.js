$(function($){

    var array = ["Tue"]

    $('.datepicker').datepicker({

        beforeShowDay: function(date){
            var string = jQuery.datepicker.formatDate('D', date);
            return [ array.indexOf(string) == -1 ]
        },

        dayNames :["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"],
        dayNamesShort: ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"],
        dayNamesMin: ["Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa"],
        monthNames: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
        monthNamesShort: ["Jan", "Fév", "Mar", "Avr", "Mai", "Jun", "Jui", "Aoû", "Sep", "Oct", "Nov", "Déc"],
        format: "dd/mm/yyyy",
        titleFormat: "MM yyyy",
        firstDay: 1,
        minDate: 0
    });


});