define(['ko'], function(ko){


    var pec = ko.observable("");
    var ssid = ko.observable("0000000");
    var requestEInvoing = ko.observable(false);
    var typeCustomer = ko.observable(0);

    typeCustomer.subscribe(function(newValue){
        if(newValue == 0){
            ssid(0000000);
        } else {
            ssid("");
        }
    });

    return function(){
        return{
            pec: pec,
            ssid: ssid,
            typeCustomer: typeCustomer,
            requestEInvoing: requestEInvoing,

            validateData: function(){
                var errors = [];
                if(!this.requestEInvoing()){
                    return errors;
                }

                if(this.pec() == "" /** validate email */){
                    errors.push("pec");
                }
                if(this.ssid() == ""){
                    errors.push("ssid");
                }
                return errors;
            }

        }
    }

});