function nb_aleatoire(min, max)
{
     var nb = min + (max-min+1)*Math.random();
     return Math.floor(nb);
}

var resultat = nb_aleatoire(0,100);
var a = prompt('Le nombre à deviner est entre 1 et 100');
var c= 1;
do{
	if(a == resultat){
		a = prompt('Bravo vous avez gagné en ' + c + ' coup(s)');
		break;
	}else if( a < resultat){
		a = prompt('Le nombre à deviner est plus grand');
	}else{
		a = prompt('Le nombre à deviner est plus petit');
	}
	c += 1;
}
while(true)