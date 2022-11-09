class AutoCompleteWidget {
	currentFocus;
	ignoreKeys = [
		37, // left arrow key
		38, // up arrow key
		39, // right arrow key
		40, // down arrow key
		38, // backspace
	]

	constructor({ajax, url, data, submitOnclick, inp}) {
		this.ajax = ajax;
		this.url = url;
		this.data = data;
		this.submitOnclick = submitOnclick;
		this.inp = inp;
	}

	debounce(callback, wait) {
		let timeout;
		return (...args) => {
			clearTimeout(timeout);
			timeout = setTimeout(function () { callback.apply(this, args); }, wait);
		};
	}
	
	addActive(x) {
		/*a function to classify an item as "active":*/
		if (!x) return false;
		/*start by removing the "active" class on all items:*/
		this.removeActive(x);
		if (this.currentFocus >= x.length) this.currentFocus = 0;
		if (this.currentFocus < 0) this.currentFocus = (x.length - 1);
		/*add class "autocomplete-active":*/
		x[this.currentFocus].classList.add("autocomplete-active");

		let myElement = x[this.currentFocus];
		let topPos = myElement.offsetTop;
		document.querySelector('.autocomplete-items').scrollTop = topPos - 200;
	}

	removeActive(x) {
		for (let i = 0; i < x.length; i++) {
			x[i].classList.remove("autocomplete-active");
		}
	}

	closeAllLists(elmnt) {
		/*close all autocomplete lists in the document,
		except the one passed as an argument:*/
		let x = document.getElementsByClassName("autocomplete-items");
		for (let i = 0; i < x.length; i++) {
			if (elmnt != x[i] && elmnt != this.inp) {
				x[i].parentNode.removeChild(x[i]);
			}
		}
	}

	createSuggestion(inp, a, val, arr=[]) {
		const self = this;
		for (let i = 0; i < arr.length; i++) {
			if (arr[i].toLowerCase().includes(val.toLowerCase())) {
				const myArray = arr[i].split(val);
				let b = document.createElement("DIV");
				/*make the matching letters bold:*/
				b.innerHTML = myArray.join("<strong>" + val + "</strong>");
				/*insert a input field that will hold the current array item's value:*/
				b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
				/*execute a function when someone clicks on the item value (DIV element):*/
				b.addEventListener("click", function(e) {
					/*insert the value for the autocomplete text field:*/
					self.inp.value = this.getElementsByTagName("input")[0].value;
					/*close the list of autocompleted values,
					(or any other open lists of autocompleted values:*/
					// closeAllLists();
					if(self.submitOnclick) {
						$(this).closest('form').submit();
					}
				});
				a.appendChild(b);
			}
		}
	}

	init() {
		const self = this;

		self.inp.setAttribute('autocomplete', 'off');

		self.inp.addEventListener('keyup', self.debounce( (e) => {
			if(! self.ignoreKeys.includes(e.keyCode)) {

				let a, b, i, val = self.inp.value;
				/*close any already open lists of autocompleted values*/
				self.closeAllLists();
				if (!val) { return false;}
				self.currentFocus = -1;
				/*create a DIV element that will contain the items (values):*/
				a = document.createElement("DIV");
				a.setAttribute("id", self.inp.id + "autocomplete-list");
				a.setAttribute("class", "autocomplete-items");
				/*append the DIV element as a child of the autocomplete container:*/
				self.inp.parentNode.appendChild(a);
				/*for each item in the array...*/
				if (self.ajax) {
					$.ajax({
						url: self.url,
						method: 'get',
						data: {keywords: val},
						dataType: 'json',
						success: (s) => {
							self.createSuggestion(self.inp, a, val, s);
						},
						error: function(e) {
							console.log(e);
						}
					})
					self.inp.classList.remove("typing");
				}
				else {
					self.createSuggestion(self.inp, a, val, {$data});
				}
			}
		}, 500));

		self.inp.addEventListener("input", function(e) {
			if(self.inp.value) {
				self.inp.classList.add("typing");
				self.closeAllLists();
			}
			else {
				self.inp.classList.remove("typing");
			}
		});

		/*execute a function presses a key on the keyboard:*/
		self.inp.addEventListener("keydown", function(e) {
			let x = document.getElementById(self.inp.id + "autocomplete-list");
			if (x) x = x.getElementsByTagName("div");
			if (e.keyCode == 40) {
				/*If the arrow DOWN key is pressed,
				increase the currentFocus variable:*/
				self.currentFocus++;
				/*and and make the current item more visible:*/
				self.addActive(x);
			} 
			else if (e.keyCode == 38) { //up
				/*If the arrow UP key is pressed,
				decrease the self.currentFocus variable:*/
				self.currentFocus--;
				/*and and make the current item more visible:*/
				self.addActive(x);
			} 
			else if (e.keyCode == 13) {
				/*If the ENTER key is pressed, prevent the form from being submitted,*/
				// e.preventDefault();
				if (self.currentFocus > -1) {
					/*and simulate a click on the "active" item:*/
					if (x) x[self.currentFocus].click();
				}
			}
		});

		/*execute a function when someone clicks in the document:*/
		document.addEventListener("click", function (e) {
			self.closeAllLists(e.target);
		});
	}
}