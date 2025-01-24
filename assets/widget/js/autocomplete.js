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

  createSuggestion(inp, a, val, arr = []) {
    const self = this;
    const trimmedVal = val.trim(); // Trim spaces from the input
    const searchTerms = trimmedVal.toLowerCase().split(/\s+/); // Split into individual terms

    for (let i = 0; i < arr.length; i++) {
      const originalItem = arr[i]; // Original suggestion
      const itemLower = originalItem.toLowerCase();

      // Check if all search terms exist in the suggestion
      const matches = searchTerms.every(term => itemLower.includes(term));
      if (matches) {
        // Highlight each term while preserving the original order and structure
        let highlightedItem = originalItem;

        // Create a list of positions for each term to highlight correctly
        const positions = [];
        searchTerms.forEach(term => {
          const regex = new RegExp(term, 'gi');
          let match;
          while ((match = regex.exec(itemLower)) !== null) {
            positions.push({ start: match.index, end: match.index + term.length });
          }
        });

        // Sort positions to avoid overlap and process from start to finish
        positions.sort((a, b) => a.start - b.start);

        // Build the highlighted string
        let finalString = '';
        let currentIndex = 0;
        positions.forEach(({ start, end }) => {
          finalString += originalItem.substring(currentIndex, start); // Add non-matching part
          finalString += `<strong>${originalItem.substring(start, end)}</strong>`; // Add highlighted part
          currentIndex = end;
        });
        finalString += originalItem.substring(currentIndex); // Add the remaining part

        // Create suggestion element
        let b = document.createElement("DIV");
        b.innerHTML = finalString; // Insert the highlighted suggestion
        b.innerHTML += `<input type='hidden' value='${originalItem}'>`;
        b.addEventListener("click", function () {
          self.inp.value = this.getElementsByTagName("input")[0].value;
          if (self.submitOnclick) {
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
					self.createSuggestion(self.inp, a, val, self.data);
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
