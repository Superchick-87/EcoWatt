

const hour = new Date().getHours();
	console.log(hour)


	/**
	 * Sert à trier des dates
	 * @param {variable issue du Json} a 
	 * @param {variable issue du Json} b 
	 * @returns les dates sont triées de la plus récente à la plus ancienne
	 */
	 function SortTime(a,b){ 
		da=new Date(a.jour);
		db=new Date(b.jour);
		return (da>db)?1:-1;
	}

	/**
	 * Sert à supprimer des caractères dans une chaine
	 * @param {la date formatée} z 
	 * @returns la date sans l'année
	 */
		 function deleteLastChar(z) { 
			y = z.substring(0, z.length -4);
			return y;
		}

		function deleteLastCharH(z) { 
			y = z.substring(0, z.length -2);
			return y;
		}


		function remplaceLegend(x) {
			const p = x;
			if (x == '0') {
				x = '0h';
				return x;
			}
			if ( x == '3') {
				x = '3h';
				return x;
			}
			if ( x == '6') {
				x = '6h';
				return x;
			}
			if ( x == '9') {
				x = '9h';
				return x;
			}
			if ( x == '12') {
				x = '12h';
				return x;
			}
			if ( x == '15') {
				x = '15h';
				return x;
			}
			if ( x == '18') {
				x = '18h';
				return x;
			}
			if ( x == '21') {
				x = '21h';
				return x;
			}
			if ( x == '23') {
				x = '23h';
				return x;
			}
			else{
				x = '';
				return x;
			}
		}

		function infoState(x) {
			const p = x;
			if (x == '1') {
				x = 'le niveau de consommation électrique est soutenable pour le réseau.';
				return x;
			}
			if (x == '2') {
				x = 'le système électrique est tendu, les écogestes sont bienvenus.';
				return x;
			}
			if (x == '3') {
				x = 'le système est très tendu, coupures à prévoir si la consommation ne baisse pas.';
				return x;
			}
		}
	
var callBackSuccess = function(data) {
	console.log("données api", data)
	// data.sort(SortTime);
	
	var element = document.getElementById('contain');
	var elementss = document.getElementsByClassName('xx');
	var codehtml = "";
	var codehtml2 = "";
	
	
	const hour = new Date().getHours();
	
	
	
	element.innerHTML += 
	"<h5 id='state'></h5>"+
	"<mark class=''>Dernière mise à jour : "+deleteLastCharH((moment(data[0].GenerationFichier).calendar()).replace(":", "h"))+"</mark>";
	
	var state = document.getElementById('state');
	console.log(state);
	for (n = 0; n < (data[0].values).length; n++) {
		if (hour == data[0].values[n].pas) {
			state.innerHTML += "&#192; "+hour+"h, "+infoState(data[0].values[n].hvalue);
			console.log(data[0].values[n].hvalue)	
		}
	}

	for (i = 0; i < data.length; i++) {
		// console.log((data[i].values).length)
		element.innerHTML += 
		"<div id="+i+" class='cartouche color'><h4>"+
		deleteLastChar(moment(data[i].jour).format('ll'))+
		"</h4>"+data[i].message+"</div>"+
		"<div>"+
			"<div id='txt"+[i]+"'>"+
				"<div id='score"+[i]+"' class='horizon'>";
		
		for (n = 0; n < (data[i].values).length; n++) {
			var elements = document.getElementById('score'+[i]+'');
			// console.log(data.values.length)
			elements.innerHTML +=  
				"<div style='width: 14px;'>"+
					"<div class='box espace hvalue"+data[i].values[n].hvalue+"'></div>"+
					"<div class='hour'>"+remplaceLegend(data[i].values[n].pas)+"</div>"+
				"</div>";	
		}
	}
		codehtml2 += "</div>"+
		"</div>"+
		
		"</div>"+
		"</div>";
  }
  
window.onload = buttonClickGET();
  
function buttonClickGET(){
	var url = 'datas/datas.json';
	$.get(url, callBackSuccess).done(function() {
		})
		.fail(function() {
			alert ("erreur");
		})
		.always(function () {
		});
}

