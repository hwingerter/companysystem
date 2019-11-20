<script type="text/javascript">
    var test = 'R$ 1.700,90';


function getMoney( str )
{
        return parseInt( str.replace(/[\D]+/g,'') );
}
function formatReal( int )
{
        var tmp = int+'';
        tmp = tmp.replace(/([0-9]{2})$/g, ",$1");
        if( tmp.length > 6 )
                tmp = tmp.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");

        return tmp;
}


var int = getMoney( test );
//alert( int );


console.log( formatReal( 1000 ) );
console.log( formatReal( 19990020 ) );
console.log( formatReal( 12006 ) );
console.log( formatReal( 111090 ) );
console.log( formatReal( 1111 ) );
console.log( formatReal( 120090 ) );
console.log( formatReal( int ) );

</script>