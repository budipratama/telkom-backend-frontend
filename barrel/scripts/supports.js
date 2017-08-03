var aTens               = ["Dua Puluh", "Tiga Puluh", "Empat Puluh", "Lima Puluh", "Enam Puluh", "Tujuh Puluh", "Delapan Puluh", "Sembilan Puluh"];
var aOnes               = ["Nol", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas", "Dua Belas", "Tiga Belas", "Empat Belas", "Lima Belas", "Enam Belas", "Tujuh Belas", "Delapan Belas", "Sembilan Belas"];

function currency_formatter(num)
{

    num                 = num.toString().replace(/\$|\,/g,'');

    if(isNaN(num))
        num 			= "0";

    sign                = (num == (num = Math.abs(num)));
    num                 = Math.floor(num*100+0.50000000001);
    cents               = num%100;
    num                 = Math.floor(num/100).toString();

    if(cents<10)
        cents           = "0" + cents;

    for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
        num             = num.substring(0,num.length-(4*i+3))+'.'+
        num.substring(num.length-(4*i+3));

    return ("IDR " + (((sign)?'':'-') + '' + num) + ",-");

}


function ConvertToHundreds(num)
{

    var cNum, nNum;
    var cWords          = "";

    num                %= 1000;
    if (num > 199)
    {
        cNum            = String(num);
        nNum            = Number(cNum.charAt(0));
        cWords         += aOnes[nNum] + " Ratus";
        num            %= 100;
        if (num > 0)
            cWords     += "  "
    }

    if (num > 99)
    {
        cWords         += "Seratus";
        num            %= 100;
        if (num > 0)
            cWords     += "  "
    }

    if (num > 19)
    {
        cNum            = String(num);
        nNum            = Number(cNum.charAt(0));
        cWords         += aTens[nNum - 2];
        num            %= 10;
        if (num > 0)
            cWords     += " ";
    }

    if (num > 0)
    {
        nNum            = Math.floor(num);
        cWords         += aOnes[nNum];
    }

    return cWords;

}


function words_converter(num)
{
    var cWords              = ""; //(num >= 1 && num < 2) ? "rupiah " : "rupiah ";

    if(num == "" || num == "0")
    {
        cWords              = "Nol";
    }
    else
    {
        var aUnits          = ["Ribu", "Juta", "Miliar", "Triliun", "Quadriliun"];
        var nLeft           = Math.floor(num);
        for (var i = 0; nLeft > 0; i++)
        {
            if (nLeft % 1000 > 0)
            {
                if (i != 0)
                    cWords  = ConvertToHundreds(nLeft) + " " + aUnits[i - 1] + " " + cWords;
                else
                    cWords  = ConvertToHundreds(nLeft) + " " + cWords;
            }

            nLeft           = Math.floor(nLeft / 1000);
        }

        num                 = Math.round(num * 100) % 100;

        if (num > 0)
            cWords         += ConvertToHundreds(num) + " Sen";
        else
            cWords         += "";
    }


    return cWords;

}


function numbersonly(e)
{

    var unicode         = e.charCode? e.charCode : e.keyCode

    if (unicode != 8)
    {
        if (unicode<48 || unicode>57)
            return false
    }

}


function spelling_number(my_num, div_value, div_terbilang)
{

    var number_only                                     = my_num.replace(".", "");

    document.getElementById(div_value).innerHTML        = currency_formatter(number_only);
    document.getElementById(div_terbilang).innerHTML    = words_converter(Number(number_only)) + " Rupiah";

    return true;

}


jQuery('select[name="province-indonesia"]').on('change', function()
{
    set_option(jQuery(this).val(), jQuery('input[name="id_city"]').val(), 'city-indonesia');
});


function set_option(province_id, city_id, select_name)
{
    if (province_id == 0)
    {
    	jQuery('select[name="' + select_name + '"]').html('<option value="">-- Pilih Kota / Kabupaten --</option>');
    };

    jQuery.ajax({
        url: get_city_url,
        type: 'post',
        data: {"province_id" : province_id}
    })
    .success(function(data)
    {
        var option 				= '';
        var selection 			= '';

        jQuery.each(data, function(i, v)
        {
        	if(v.id == city_id)
        		selection 		= "selected=\"selected\"";
        	else
        		selection 		= "";

            option 				+= "<option value='" + v.id + "' " + selection + ">" + v.name + "</option>";
        });

        jQuery('select[name="' + select_name + '"]').html(option);
    });
}