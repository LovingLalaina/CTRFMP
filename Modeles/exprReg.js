

//UN NUMERO DE PENSION COMMENCE PAR UN CHIFFRE 0 OU 1, SUIVI D'UNE LETTRE, PUIS D'UNE SEQUENCE DE 5 CHIFFRE OU LETTRE
var numeroPension_regex = /(^[0-1])([a-zA-Z])([a-zA-Z0-9]{5})$/;
//var numeroCIN_regex = /(^[c])(?=([0-9]{12}))/;
var numeroCIN_regex = /(^[c])([0-9]{12})$/i;

//EXPRESSION POUR LES NOMS ET PRENOMS
var nomPensionnaire_regex;
var prenomPensionnaire_regex = nomPensionnaire_regex = /^[a-zA-ZéèêëîïñöôÉÈÊËÎÏÑÖÔ][a-zéèêëîïñöô]+([-'\s][a-zA-ZéèêëîïñöôÉÈÊËÎÏÑÖÔ][a-zéèêëîïñöô]+)?/i;

//LES NUMERO D'ENGAGEMENT ET BORDEREAU SONT DES SEQUENCES DE 16 CHIFFRES INUTIL A PRESENT
// var numeroEngagement_regex;
// var numeroBordereau_regex = numeroEngagement_regex = /(^ENG)(?=([0-9]{16}))/;