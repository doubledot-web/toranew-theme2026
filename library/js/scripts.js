"use strict";

jQuery(document).ready(function ($) {
	let winWidth;
	const desktopBreakpoint = 768;

	termsArchive();

	function termsArchive() {
		$(".terms-archive select").on("change", function () {
			let pdf = window.open($(this).val(), "_blank");
			pdf.focus();
		});
	}

	window.fitloaded = false;

	// SLICKNAV
	$("#menu-mobile-menu").slicknav({
		label: "",
		closedSymbol: '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
		openedSymbol: '<i class="fa fa-chevron-down" aria-hidden="true"></i>',
		appendTo: "#header",
	});
	// END SLICKNAV

	// ACTIVATE COUNTER EFFECT ON SCROLL TO ELEMENT
	$(window).on("scroll", function () {
		if ($(".counter").length < 1) {
			return false;
		}

		var counterOffset = $(".counter").offset().top - window.innerHeight;

		if (
			$(".complete").length == 0 &&
			$(window).scrollTop() > counterOffset
		) {
			$(".counter span").each(function () {
				var $this = $(this),
					countTo = $this.attr("data-count");

				$({
					countNum: $this.text(),
				}).animate(
					{ countNum: countTo },
					{
						duration: 1000,
						easing: "swing",
						step: function () {
							$this.text(
								Math.floor(this.countNum).toLocaleString("el")
							);
						},
						complete: function () {
							$this.text(this.countNum.toLocaleString("el"));
							$this.addClass("complete");
						},
					}
				);
			});
		}
	});
	// END ACTIVATE COUNTER EFFECT ON SCROLL TO ELEMENT

	// SOCIAL MENU DROPDOWN
	var socialNav = $(".social-nav");
	var socialNavHeight = $(socialNav).height();

	var subMenuEl = $(".social-nav .sub-menu");
	var subMenuHeight = $(subMenuEl).height();

	$(".menu-item-has-children").prepend('<div class="arrow-down"></div>');

	var totalHeight = socialNavHeight + subMenuHeight;

	subMenuEl.css({
		top: -totalHeight + "px",
	});
	// END SOCIAL MENU DROPDOWN

	// ACCORDION
	var allPanels = $(".accordion > dd").css("max-height", 0);
	var allTiles = $(".accordion > dt");

	$(".accordion > dt > a").on("click", function () {
		if ($(this).parent().hasClass("expanded")) {
			$(this).parent().removeClass("expanded");
			$(this).parent().next().css({
				"max-height": 0,
			});

			return false;
		}

		allPanels.css("max-height", 0);
		allTiles.removeClass("expanded");

		var totalHeight = 0;
		$(this)
			.parent()
			.next()
			.children()
			.each(function () {
				totalHeight += $(this).outerHeight(true); // include margins
			});

		$(this).parent().addClass("expanded");
		$(this)
			.parent()
			.next()
			.css("max-height", totalHeight + 50);

		// $('.carousel-list > ul').slick('setPosition');

		return false;
	});

	// Break carousel items to contain specific row numbers
	$(".accordion .carousel-list > ul, .carousel-wrapper").each(function () {
		var lis = $(this).find("li");

		for (var i = 0; i < lis.length; i += 4) {
			lis.slice(i, i + 4).wrapAll('<ul class="slide"></ul>');
		}
	});

	// Accordion hash functionality
	if ($(".accordion").length > 0 && window.location.hash) {
		$(window.location.hash).trigger("click");
	}
	// END ACCORDION

	// INITIALIZE SLICK CAROUSEL
	$(".carousel-list > ul, .carousel-wrapper > ul").slick({
		dots: true,
		arrows: false,
		slidesToShow: 3,
		infinite: false,
		responsive: [
			{
				breakpoint: 767,
				settings: {
					slidesToShow: 2,
				},
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
				},
			},
		],
	});
	// END INITIALIZE SLICK CAROUSEL

	// MAP FUNCTIONALITY
	$("#map-list-toggler a").on("click", function (e) {
		e.preventDefault();

		if ($(this).hasClass("active")) {
			return false;
		}

		if ($(this).hasClass("show-map")) {
			$(".show-list").removeClass("active");
			$(".list-section").hide();

			$(".show-map").removeClass("active").addClass("active");
			$(".map-section").show();
		} else {
			$(".show-map").removeClass("active");
			$(".map-section").hide();

			$(".show-list").removeClass("active").addClass("active");
			$(".list-section").show();
		}
	});

	// Map No Results / Loading messages adust positioning
	$(window).on("resize load", function () {
		winWidth = $(window).width(); // Get the current window width

		var mapHeaderHeight =
			$("#map-filters").outerHeight() +
			$("#map-list-toggler").outerHeight();

		locationsCountSelectorPosition();

		$("#map-no-content, #map-loader").css({
			top: mapHeaderHeight + "px",
			height: $("#map-markers").height() + "px",
		});
	});
	// END MAP FUNCTIONALITY

	// MAP
	$(".map-mobile-filters a").on("click", function (e) {
		e.preventDefault();
		$(".categories-section").addClass("active");
	});
	$(".categories-section .close").on("click", function (e) {
		e.preventDefault();
		$(".categories-section").removeClass("active");
	});

	// LIST PAGINATION
	var locations;

	// navigator.geolocation.watchPosition(
	// 	function(position) {
	// 		console.log('position');
	// 		console.log(position)
	// 	},
	// 	function(error) {
	// 		console.log(error);
	//   	}
	// );

	$("body").on("update-markers", "#map-markers", function () {
		if (!window.fitloaded) {
			fitBounds(); // Center map to display all active markers
		}
		locations = $(".location-item").toArray();
		assignServicesLabelColors();
		togglePagination(); // Toggle pagination if there are no items
	});

	$("body").on("click touchend", "#map-markers", function () {
		assignServicesLabelColors();
	});

	// Show map tab actions
	$("body").on("click", "#map-list-toggler .show-map", function (e) {
		preventActiveClick(e); // Prevent click if active tab
		fitBounds(); // Center map to display all active markers
		$("#map-no-content").css("position", "absolute");
		$(".map-mobile-filters").removeClass("hidden");
	});

	// Show list tab actions
	$("body").on("click", "#map-list-toggler .show-list", function (e) {
		preventActiveClick(e); // Prevent click if active tab
		togglePagination(); // Toggle pagination if there are no items
		// $('#map-no-content').css('position', 'static');

		$(".map-mobile-filters").addClass("hidden");
	});

	// Dropdown field to change the number of shown items
	$("body").on("change", ".locations-count-selector select", function () {
		$(".locations-count-selector select").val($(this).val()); // Update both dropdowns
		$(".locations-pagination").pagination("destroy");
		paginationInit($(this).val());
		locationsCountSelectorPosition();
	});

	// Synchronize pagination functionality for both pagination elements
	$("body").on("mousedown click", ".locations-pagination li", function (e) {
		var page = $(e.currentTarget).data("num");
		$(".locations-pagination").pagination("go", page);
	});

	// Assign Services Label Colors
	function assignServicesLabelColors() {
		$(".location-item .label").each(function () {
			switch ($(this).text()) {
				case "Ανανέωση χρόνου ομιλίας/Internet":
					$(this).addClass("bg-blue");
					break;
				case "Πληρωμή λογαριασμών":
					$(this).addClass("bg-dark-blue");
					break;
				case "Μεταφορά Χρημάτων":
					$(this).addClass("bg-light-blue");
					break;
				case "Ενέργεια ":
					$(this).addClass("bg-blue");
					break;
				default:
					$(this).addClass("bg-blue");
					break;
			}
		});
	}

	// Toggle pagination
	function togglePagination() {
		if (locations.length == 0) {
			$(".locations-pagination").pagination("destroy");
			$(".locations-count-selector, .locations-pagination").hide();
			$("#map-no-content").css("display", "flex");
			$("#map-markers, #map-locations").css("opacity", ".3");
			setTimeout(function () {
				$("#map-no-content").hide();
				$("#map-markers, #map-locations").css("opacity", "1");
			}, 2500);
		} else {
			paginationInit($(".locations-count-selector select").val());
			$(".locations-pagination").fadeIn(function () {
				locationsCountSelectorPosition();
				$(".locations-count-selector").fadeIn();
			});
			$("#map-no-content").hide();
			$("#map-markers, #map-locations").css("opacity", "1");
		}
	}

	// Prevent click on active elements
	function preventActiveClick(e) {
		if ($(e.target).hasClass("active")) {
			return false;
		}
	}

	// Center map to display all active markers
	function fitBounds() {
		var bounds = new google.maps.LatLngBounds();

		if (markers.length > 0) {
			for (var i = 0; i < markers.length; i++) {
				bounds.extend(markers[i].getPosition());
			}
			map.fitBounds(bounds);
		} else {
			var center = new google.maps.LatLng(37.9747815, 23.732726); // Athens coordinates
			map.panTo(center);
			map.setZoom(6);
		}
	}

	// Locations Count Selector Position adjust
	function locationsCountSelectorPosition() {
		$(".locations-count-selector").css(
			"left",
			$(".results-indicator").width() + "px"
		);
	}

	// Initialize Pagination
	function paginationInit(pageSize) {
		var paginationArgs = {
			dataSource: locations,
			pageSize: pageSize,
			showNavigator: true,
			formatNavigator: '<div class="results-indicator"></div>',
			prevText: '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
			nextText: '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
			autoHidePrevious: true,
			autoHideNext: true,
			showNavigator: true,
			callback: function (data, pagination) {
				$("#map-locations").html(data);
			},
			afterPaging: function (activePage) {
				var totalLocations, visibleLocations, fromResults, toResults;

				totalLocations = locations.length;
				visibleLocations = $(".locations-count-selector select").val();

				fromResults =
					activePage * visibleLocations - (visibleLocations - 1);
				toResults = activePage * visibleLocations;

				if (toResults > totalLocations) {
					toResults = toResults - (toResults - totalLocations);
				}

				$(".results-indicator").html(
					"<span>Αποτελέσματα</span><span>" +
						fromResults +
						" - " +
						toResults +
						" από " +
						totalLocations +
						"</span>"
				);

				locationsCountSelectorPosition();
			},
		};

		$(".locations-pagination-top").pagination(paginationArgs);
		$(".locations-pagination-bottom").pagination(paginationArgs);
	}
	// END MAP LIST PAGINATION

	// ADAPT TEXT COLOR ACCORDING TO BACKGROUND
	adaptColor(".has-bg-color");

	function adaptColor(selector) {
		var rgb = $(selector).css("background-color");

		if (rgb && rgb.match(/^rgb/)) {
			var a = rgb.match(
					/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+(?:\.\d+)?))?\)$/
				),
				r = a[1],
				g = a[2],
				b = a[3];
		}

		var hsp = Math.sqrt(
			0.299 * (r * r) + 0.587 * (g * g) + 0.114 * (b * b)
		);

		if (hsp > 127.5) {
			$(selector).find(".column").addClass("light-color");
		} else {
			$(selector).find(".column").addClass("dark-color");
		}
	}
	// END ADAPT TEXT COLOR ACCORDING TO BACKGROUND

	// FORM VALIDATION

	if ($("#certificationForm").length > 0) {
		validateForm("#certificationForm");
	}

	if ($("#complaintForm").length > 0) {
		const services = global_vars.services;
		toggleServiceSelectInfo(services);
		validateForm("#complaintForm");
	}

	if ($("#feedbackForm").length > 0) {
		validateForm("#feedbackForm");
	}

	// function removeFormMsgClasses() {
	// 	setTimeout(function () {
	// 		$(".wpcf7-form").removeClass("sent");
	// 		$(".wpcf7-form").removeClass("failed");
	// 		$(".wpcf7-form").removeClass("invalid");
	// 		$(".wpcf7-form").addClass("init");
	// 	}, 5000);
	// }

	function validateForm(form) {
		const formsWithAnimatedLabels =
			document.querySelectorAll(".form-control");
		const orderedElements = [];
		const focusedClass = "focused-input";
		const activeClass = "active-input";
		const inputErrorClass = "input-error";

		if (formsWithAnimatedLabels.length > 0) {
			for (const formControl of formsWithAnimatedLabels) {
				orderedElements.push(formControl.id);
				formControl.addEventListener("focus", function () {
					this.parentElement.classList.add(focusedClass);
				});
				formControl.addEventListener("blur", function () {
					// if (!this.value) {
					this.parentElement.classList.remove(focusedClass);
					// }
				});
			}

			orderedElements.push("responseMethodInput");
		}

		$(".form-button").on("click", function (e) {
			$("#uploadFileInputVal").val("");
			let dndHasErrors = $("#uploadFileWrapper").find(".has-error");

			if (dndHasErrors.length > 0) {
				$("#uploadFileInputVal").val("dndError");
			}
		});

		// $(document).on("DOMNodeInserted", ".has-error", function () {
		// Perform actions when an element with the specified class is inserted into the DOM
		// console.log("An element with the class .has-error has appeared.");
		// });

		$(".wpcf7-form").on("submit", function (e) {
			$(".wpcf7-form-control").each(function () {
				$(this).parent().removeClass("input-error");
			});

			setTimeout(function () {
				$(".wpcf7-form").removeClass("sent");
				$(".wpcf7-form").removeClass("failed");
				$(".wpcf7-form").removeClass("invalid");
				$(".wpcf7-form").addClass("init");
			}, 5000);
		});

		$(document).on("change", ".form-control", function () {
			if ($(this).val() !== "") {
				$(this).parent().addClass("active-input");
			} else {
				$(this).parent().removeClass("active-input");
			}
		});

		$(".val-counter").on("keyup change", function () {
			let charCount = $(this).val().length;
			if ($("#" + $(this).attr("name") + "Count").length) {
				$("#" + $(this).attr("name") + "Count span").text(charCount);
			}
		});

		$("#legalFormInput").on("change", function () {
			if ($(this).val() === "Άλλο") {
				$("#legalformOtherBlock").removeClass("d-none");
				// Add focus state to legalformOtherInput input
				$("#legalformOtherInput").focus();
			} else {
				// remove focus state from legalformOtherInput input
				$("#legalformOtherInput").blur();
				$("#legalformOtherBlock").addClass("d-none");
			}
		});

		document.addEventListener(
			"wpcf7mailsent",
			function (event) {
				const inputs = document.querySelectorAll(".focused-input");
				if (inputs.length > 0) {
					for (const input of inputs) {
						input.classList.remove(focusedClass);
					}
				}

				const inputErrors = document.querySelectorAll(".input-error");
				if (inputErrors.length > 0) {
					for (const inputError of inputErrors) {
						inputError.classList.remove(inputErrorClass);
					}
				}

				var thankyouURL = document.getElementById("thankyouURL").value;
				location = thankyouURL;
			},
			false
		);

		document.addEventListener(
			"wpcf7mailfailed",
			function (event) {
				$(".wpcf7-form").removeClass("init");
			},
			false
		);

		$(window).on("wpcf7invalid", function (event) {
			if ($("#telInput").length > 0 && $("#eMailInput").length > 0) {
				if (!$("#telInput").val() && !$("#eMailInput").val()) {
					$("#telInput").parent().addClass("input-error");
					var inputError = {
						field: "tel",
						idref: "telInput",
						message: "",
					};
				}
			}
			$(".wpcf7-form").removeClass("init");
			const inputErrors = event.detail.apiResponse.invalid_fields;
			if (inputError) {
				inputErrors.push(inputError);
			}

			inputErrors.forEach(function (element) {
				if (element.field === "upload-file") {
					element.idref = "uploadFileWrapper";
				}
			});

			// console.log(inputErrors);
			// console.log(orderedElements);

			// sort inputErrors array according to orderedElements array if values exists in both arrays
			if (inputErrors.length > 0) {
				inputErrors.sort(function (a, b) {
					return (
						orderedElements.indexOf(a.idref) -
						orderedElements.indexOf(b.idref)
					);
				});

				inputErrors.forEach(function (element) {
					$("#" + element.idref)
						.parent()
						.addClass("input-error");
				});

				const element = document.querySelector(
					"#" + inputErrors[0].idref
				);

				const y = element.getBoundingClientRect().top + window.scrollY;
				window.scrollTo({ top: y, behavior: "smooth" });
			}
		});

		const button = document.getElementById("certificationFormSubmit");

		$("#addressInput").on("focus", function () {
			button.setAttribute("disabled", "");
		});

		$("#addressInput").on("blur", function () {
			button.removeAttribute("disabled", "");
		});
	}
	// END FORM VALIDATION

	toggleStickyPopup();

	function toggleStickyPopup() {
		var popup = $(".wpcf7-response-output");
		var container = $(".theme-form-section");

		$(window).on("load, scroll", function () {
			var scrollPosition = $(window).scrollTop();
			var containerHeight = container.outerHeight();
			var viewportHeight = $(window).height();

			if (
				container.offset() &&
				scrollPosition + viewportHeight >=
				container.offset().top + containerHeight
			) {
				// User has scrolled to the bottom of the container
				popup.addClass("bottom-reached");
			} else if (scrollPosition + viewportHeight >= containerHeight) {
				popup.addClass("bottom-reached");
			} else {
				// User is at the top of the page
				popup.removeClass("bottom-reached");
			}
		});
	}

	function toggleServiceSelectInfo(services) {
		if (!Array.isArray(services) && services.length <= 0) {
			return;
		}

		$("#serviceInput").on("change", function () {
			$(".transaction").removeClass("active");
			if ($(this).val()) {
				let serviceName = $(this).val();

				if (
					!Array.isArray(services[serviceName]) &&
					services[serviceName].length <= 0
				) {
					return;
				}

				for (const transactioId of services[serviceName]) {
					$(".transaction_" + transactioId).addClass("active");
				}
			}
		});
	}

	function isIterable(obj) {
		// checks for null and undefined
		if (obj == null) {
			return false;
		}
		return typeof obj[Symbol.iterator] === "function";
	}

	let autocomplete;
	let addressInput;
	let cityInput;
	let zipCodeInput;

	function initAutocomplete() {
		addressInput = document.querySelector("#addressInput");
		cityInput = document.querySelector("#cityInput");
		zipCodeInput = document.querySelector("#zipCodeInput");
		// Create the autocomplete object, restricting the search predictions to
		// addresses in the US and Canada.
		autocomplete = new google.maps.places.Autocomplete(addressInput, {
			componentRestrictions: { country: ["gr"] },
			language: "el",
			fields: ["address_components", "geometry"],
			types: ["address"],
		});
		// When the user selects an address from the drop-down, populate the
		// address fields in the form.
		autocomplete.addListener("place_changed", fillInAddress);
	}

	function fillInAddress() {
		// Get the place details from the autocomplete object.
		const place = autocomplete.getPlace();
		let addressWithNumber = "";
		let addressNumber = "";
		let addressName = "";
		let zipCode = "";

		// Get each component of the address from the place details,
		// and then fill-in the corresponding field on the form.
		// place.address_components are google.maps.GeocoderAddressComponent objects
		// which are documented at http://goo.gle/3l5i5Mr

		if (isIterable(place.address_components)) {
			for (const component of place.address_components) {
				// @ts-ignore remove once typings fixed
				const componentType = component.types[0];

				switch (componentType) {
					case "street_number": {
						addressNumber = `${component.long_name}`;
						break;
					}

					case "route": {
						addressName += component.short_name;
						break;
					}

					case "postal_code": {
						zipCode = `${component.long_name}`;
						break;
					}

					case "locality":
						$("#cityInput")
							.val(component.long_name)
							.parent()
							.addClass("active-input");
						break;

					case "administrative_area_level_3": {
						$("#countyInput")
							.val(component.short_name)
							.parent()
							.addClass("active-input");
						break;
					}
				}
			}
			addressWithNumber = `${addressName} ${addressNumber}`;
			$("#addressInput")
				.val(addressWithNumber)
				.parent()
				.addClass("active-input");
			$("#zipCodeInput").val(zipCode).parent().addClass("active-input");

			const button = document.getElementById("certificationFormSubmit");
			button.removeAttribute("disabled");
		}
	}

	initAutocomplete();

	// function ApplyAutoComplete(input, options) {
	// 	var autocomplete = new google.maps.places.Autocomplete(input, options);
	// 	console.log(autocomplete);
	// }

	// var inputs = document.getElementsByClassName("wpcf7-gmautocomplete");
	// for (var i = 0; i < inputs.length; i++) {
	// 	ApplyAutoComplete(inputs[i], {});
	// }
});
