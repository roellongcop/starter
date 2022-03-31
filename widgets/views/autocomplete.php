<?php

$this->registerCss(<<< CSS
	
	/*the container must be positioned relative:*/
	.autocomplete {
		position: relative;
		display: block;
	}
	.autocomplete-items {
		position: absolute;
		border: 1px solid #d4d4d4;
		border-bottom: none;
		border-top: none;
		z-index: 99;
		/*position the autocomplete items to be the same width as the container:*/
		top: 100%;
		left: 0;
		right: 0;
		overflow: auto;
	    max-height: 500px;
	}
	.autocomplete-items::-webkit-scrollbar {
	    width: 5px;
	}
	.autocomplete-items::-webkit-scrollbar-track {
	    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.2); 
	    border-radius: 10px;
	}

	.autocomplete-items::-webkit-scrollbar-thumb {
	    border-radius: 10px;
	    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,24%); 
	}
	.autocomplete-items div {
		padding: 10px;
		cursor: pointer;
		background-color: #fff; 
		border-bottom: 1px solid #d4d4d4; 
		color: #3F4254;
		word-break: break-all;
	}
	/*when hovering an item:*/
	.autocomplete-items div:hover {background-color: #e9e9e9;}
	/*when navigating through the items using the arrow keys:*/
	.autocomplete-active {
		background-color: DodgerBlue !important; 
		color: #ffffff !important; 
	}

	.autocomplete input.typing {
		background: url(/default/loading.gif) no-repeat right center !important;
	}
CSS, [], 'autocomplete');

$this->registerWidgetJs($widgetFunction, <<< JS
	var ignoreKeys = [
		37, // left arrow key
		38, // up arrow key
		39, // right arrow key
		40, // down arrow key
		38, // backspace
	];

	function autocomplete(inp) {
		function debounce(callback, wait) {
			let timeout;
			return (...args) => {
				clearTimeout(timeout);
				timeout = setTimeout(function () { callback.apply(this, args); }, wait);
			};
		}

		/*the autocomplete function takes two arguments,
		the text field element and an array of possible autocompleted values:*/
		var currentFocus;
		/*execute a function when someone writes in the text field:*/
		 
		inp.addEventListener('keyup', debounce( (e) => {
			if(! ignoreKeys.includes(e.keyCode)) {

				var a, b, i, val = inp.value;
				/*close any already open lists of autocompleted values*/
				closeAllLists();
				if (!val) { return false;}
				currentFocus = -1;
				/*create a DIV element that will contain the items (values):*/
				a = document.createElement("DIV");
				a.setAttribute("id", inp.id + "autocomplete-list");
				a.setAttribute("class", "autocomplete-items");
				/*append the DIV element as a child of the autocomplete container:*/
				inp.parentNode.appendChild(a);
				/*for each item in the array...*/
				if ({$ajax}) {
					$.ajax({
						url: '{$url}',
						method: 'get',
						data: {keywords: val},
						dataType: 'json',
						success: function(s) {
							createSuggestion(inp, a, val, s);
						},
						error: function(e) {
							console.log(e);
						}
					})
					inp.classList.remove("typing");
				}
				else {
					createSuggestion(inp, a, val, {$data});
				}
			}
		}, 500));

		inp.addEventListener("input", function(e) {
			if(this.value) {
				this.classList.add("typing");
				closeAllLists();
			}
			else {
				this.classList.remove("typing");
			}
		});

		/*execute a function presses a key on the keyboard:*/
		inp.addEventListener("keydown", function(e) {
			var x = document.getElementById(this.id + "autocomplete-list");
			if (x) x = x.getElementsByTagName("div");
			if (e.keyCode == 40) {
				/*If the arrow DOWN key is pressed,
				increase the currentFocus variable:*/
				currentFocus++;
				/*and and make the current item more visible:*/
				addActive(x);
			} 
			else if (e.keyCode == 38) { //up
				/*If the arrow UP key is pressed,
				decrease the currentFocus variable:*/
				currentFocus--;
				/*and and make the current item more visible:*/
				addActive(x);
			} 
			else if (e.keyCode == 13) {
				/*If the ENTER key is pressed, prevent the form from being submitted,*/
				// e.preventDefault();
				if (currentFocus > -1) {
					/*and simulate a click on the "active" item:*/
					if (x) x[currentFocus].click();
				}
			}
		});
		function addActive(x) {
			/*a function to classify an item as "active":*/
			if (!x) return false;
			/*start by removing the "active" class on all items:*/
			removeActive(x);
			if (currentFocus >= x.length) currentFocus = 0;
			if (currentFocus < 0) currentFocus = (x.length - 1);
			/*add class "autocomplete-active":*/
			x[currentFocus].classList.add("autocomplete-active");

			var myElement = x[currentFocus];
			var topPos = myElement.offsetTop;
			document.querySelector('.autocomplete-items').scrollTop = topPos - 200;
		}
		function removeActive(x) {
		/*a function to remove the "active" class from all autocomplete items:*/
			for (var i = 0; i < x.length; i++) {
				x[i].classList.remove("autocomplete-active");
			}
		}
		function closeAllLists(elmnt) {
			/*close all autocomplete lists in the document,
			except the one passed as an argument:*/
			var x = document.getElementsByClassName("autocomplete-items");
			for (var i = 0; i < x.length; i++) {
				if (elmnt != x[i] && elmnt != inp) {
					x[i].parentNode.removeChild(x[i]);
				}
			}
		}
		function createSuggestion(inp, a, val, arr=[]) {
			for (i = 0; i < arr.length; i++) {
				if (arr[i].toLowerCase().includes(val.toLowerCase())) {
					const myArray = arr[i].split(val);
					b = document.createElement("DIV");
					/*make the matching letters bold:*/
					b.innerHTML = myArray.join("<strong>" + val + "</strong>");
					/*insert a input field that will hold the current array item's value:*/
					b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
					/*execute a function when someone clicks on the item value (DIV element):*/
					b.addEventListener("click", function(e) {
						/*insert the value for the autocomplete text field:*/
						inp.value = this.getElementsByTagName("input")[0].value;
						/*close the list of autocompleted values,
						(or any other open lists of autocompleted values:*/
						// closeAllLists();
						if({$submitOnclick}) {
							$(this).closest('form').submit();
						}
					});
					a.appendChild(b);
				}
			}
		}
		/*execute a function when someone clicks in the document:*/
		document.addEventListener("click", function (e) {
			closeAllLists(e.target);
		});
	}

	var selector = ".autocomplete-{$widgetId} input";
	$(selector).attr('autocomplete', 'off');

	/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
	autocomplete(document.querySelector(selector));
JS);

?>

<div class="autocomplete autocomplete-<?= $widgetId ?>">
	<?= $input ?>
</div>
