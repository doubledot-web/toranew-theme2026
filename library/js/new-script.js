let page_storage = window.localStorage;
const windowLocation = window.location.href;

function CheckBanner() {
	const topBannerUpHolder = document.getElementById("topBanner-up-holder");
	const banner = document.getElementById("app-up-banner");

	// console.log(topBannerUpHolder);
	if (!topBannerUpHolder) {
		return;
	}
	const TodayTimestamp = new Date().getTime();
	const timestamp = page_storage.getItem("seen-timestamp")
		? page_storage.getItem("seen-timestamp")
		: null;
	const topBannerFrequencySee = Number(
		topBannerUpHolder.getAttribute("frequency")
	);
	const homePage = "https://uat.tora.gr/";
	const ToraPage = windowLocation.includes("tora-app");
	const OroiXrisisPage = windowLocation.includes("oroi-xrhshs-tora-app");
	const PolitikiAporitou = windowLocation.includes("privacy-policy-tora-app");
	if (!timestamp) {
		if (ToraPage || windowLocation == homePage) {
			if (OroiXrisisPage || PolitikiAporitou) {
				banner.style.display = "flex";
			}
			return;
		} else {
			banner.style.display = "flex";
		}
		return;
	}
	const delay = topBannerFrequencySee * 3600 * 1000 * 24;
	console.log(delay);
	if (TodayTimestamp > Number(timestamp) + delay) {
		banner.style.display = "flex";
		page_storage.setItem("seen-timestamp", TodayTimestamp.toString());
	} else {
		banner.style.display = "none";
		return;
	}

	if (ToraPage || windowLocation == homePage) {
		if (OroiXrisisPage) {
			banner.style.display = "flex";
		}
		return;
	} else {
		banner.style.display = "flex";
	}
}

function removeBanner() {
	const banner = document.getElementById("app-up-banner");
	const TodayTimestamp = new Date().getTime();
	page_storage.setItem("seen-timestamp", TodayTimestamp.toString());
	banner.style.display = "none";
}

setTimeout(() => {
	CheckBanner();
}, 200);

/** Adding first New (Neo) text to to first menu element */
let firstNavElement =
	document.querySelector(".first-menu-item").firstElementChild;
let firstMenuELementInnerHtml = firstNavElement.innerHTML;
/** Check here if first menu element containes the word tora to apply the new word */
if (firstMenuELementInnerHtml.includes("Tora")) {
	let newElement = document.createElement("p");
	newElement.classList.add("newMenuClass");
	newElement.innerHTML = "ΝΕΟ";
	firstNavElement.appendChild(newElement);
}

setTimeout(() => {
	let mobMenuIcon = document.querySelector(".slicknav_btn");
	if (!mobMenuIcon) {
		return;
	}
	mobMenuIcon.addEventListener("click", () => {
		let slickNav =
			document.querySelector(".slicknav_nav").firstElementChild;
		let slickNavFirstChild = slickNav.firstElementChild;
		let slickNavFirstHtml = slickNavFirstChild.innerHTML;
		// Mobile Menu
		/** Check here if first menu element containes the word tora to apply the new word */
		if (slickNavFirstHtml.includes("Tora")) {
			let newElementMob = document.createElement("p");
			newElementMob.classList.add("newMenuClassMOB");
			newElementMob.innerHTML = "ΝΕΟ";
			slickNavFirstChild.appendChild(newElementMob);
		}
	});
}, 200);

window.addEventListener("load", (event) => {
	let ArrowDownElements = document.querySelectorAll(".arrow-down");
	ArrowDownElements.forEach((ArrowDownElement) => {
		// console.log(ArrowDownElement);
		// ArrowDownElement.id = "dropDownArrow";
		let parentElement = ArrowDownElement.parentElement;
		// let parentElementID = ArrowDownElement.id;
		let aElement = parentElement.getElementsByTagName("a")[0];
		aElement.style.cursor = "pointer";

		let ulElement = parentElement.getElementsByClassName("sub-menu")[0];
		let newElementDownIcon = document.createElement("i");
		newElementDownIcon.classList.add("fa");
		newElementDownIcon.classList.add("fa-angle-down");
		ArrowDownElement.appendChild(newElementDownIcon);
		aElement.removeAttribute("href");

		parentElement.addEventListener("mouseover", (e) => {
			console.log("clciked");
			newElementDownIcon.classList.add("rotate-anchor");
		});
		parentElement.addEventListener("mouseleave", (e) => {
			console.log("clciked");
			newElementDownIcon.classList.remove("rotate-anchor");
		});
	});
});

// setTimeout(() => {

// }, 200);

{
	/* <i class="far fa-angle-down"></i> */
}

/** Adding New To widget Menu */
let menuWidget1 = document.querySelector(".widget-1");
let menuWidgetElement = null;
if (menuWidget1) {
	menuWidgetElement = menuWidget1.firstElementChild;
}
let menuWidgetElementInnerHtml = firstNavElement.innerHTML;
if (menuWidgetElementInnerHtml.includes("Tora") && menuWidgetElement) {
	// menuWidgetElement.style.marginBottom = "-12px";
	// let newElement = document.createElement("p");
	// newElement.classList.add("newMenuClass2");
	// newElement.innerHTML = "ΝΕΟ";
	// menuWidgetElement.appendChild(newElement);
}

if (document.getElementById("msb")) {
	let submenuLineUp = document.getElementById("msb").children;
	let selected = window.location.href;

	let selectedText = selected.split("?sb=")[1];

	let selecDocum = document.getElementById(selectedText);
	if (selectedText != null) {
		Array.from(submenuLineUp).forEach((submenu) => {
			const id = submenu.id;
			submenu.removeAttribute("selected");

			if (submenu.id.trim() === selectedText.trim()) {
				submenu.setAttribute("selected", "");
			}
		});
	}
}

let menuCopyRightMenu = document.getElementById("menu-copyright-menu").children;
if (window.innerWidth > 768) {
	for (let i = 0; i < Array.from(menuCopyRightMenu).length; i++) {
		if (i == 0) {
			continue;
		}
		let singleElement = menuCopyRightMenu[i].firstElementChild;
		let singleElementHtml = singleElement.innerHTML;
		let spLiElement = document.createElement("span");
		spLiElement.innerHTML = "|";
		spLiElement.classList.add("spaceLi");
		singleElement.prepend(spLiElement);
	}
}

window.addEventListener("change", () => {
	let selected = window.location.href;
});

function subClicked(item) {
	setTimeout(() => {
		let selected = window.location.href;
	}, 1500);

	return item;
}

function openFullAccordion(id) {
	console.log(id);
	let ddElement = document.getElementById(id);
	console.log(ddElement);
	// ddElement.classList.toggle('ddNoneHeight');
	// ddElement.style.maxHeight = 'none !important;'
	// .accordion dd {
	// max-height: none !important;
}

jQuery(window).on("load", function () {
	// console.log("load");
	let crslHome = jQuery("#carouselHome").carousel();
	crslHome.carousel("pause");
	let crlsMidi = jQuery("#carouselMidi").carousel();
	crlsMidi.carousel("pause");
	let crslMini1 = jQuery("#carouselM1").carousel();
	crslMini1.carousel("pause");
	let crslMini2 = jQuery("#carouselM2").carousel();
	crslMini2.carousel("pause");
	let crslMini3 = jQuery("#carouselM3").carousel();
	crslMini3.carousel("pause");
});

jQuery("#startStop").on("click", function () {
	console.log("clicked");
	let crsl = jQuery("#carouselHome").carousel();
	jQuery("#carouselHome").data("interval", "4000");
	if (!jQuery(this).hasClass("paused")) {
		crsl.carousel("pause");
		jQuery(".btn-customized").toggleClass("paused");
		jQuery(".btn-customized i").removeClass("fa-pause").addClass("fa-play");
		jQuery(this).blur();
	} else {
		crsl.carousel("cycle");
		setTimeout(() => {
			jQuery("#carouselHome").carousel("next");
		}, 1000);
		// jQuery('#carouselHome').carousel('next');
		jQuery(".btn-customized").toggleClass("paused");
		jQuery(".btn-customized i").removeClass("fa-play").addClass("fa-pause");
		jQuery(this).blur();
	}
});

// Mini Slider 1
jQuery("#startStopMS1").on("click", function () {
	console.log("clicked");
	let crsl = jQuery("#carouselM1").carousel();
	if (!jQuery(this).hasClass("paused")) {
		// jQuery('.carousel').carousel( );
		crsl.carousel("pause");
		jQuery(".btn-customized-mini1").toggleClass("paused");
		jQuery(".btn-customized-mini1 i")
			.removeClass("fa-pause")
			.addClass("fa-play");
		jQuery(this).blur();
	} else {
		// jQuery('#carousel').carousel('cycle');
		crsl.carousel("cycle");
		jQuery(".btn-customized-mini1").toggleClass("paused");
		jQuery(".btn-customized-mini1 i")
			.removeClass("fa-play")
			.addClass("fa-pause");
		jQuery(this).blur();
	}
});
// Mini Slider 2
jQuery("#startStopMS2").on("click", function () {
	console.log("clicked");
	let crsl = jQuery("#carouselM2").carousel();
	if (!jQuery(this).hasClass("paused")) {
		// jQuery('.carousel').carousel( );
		crsl.carousel("pause");
		jQuery(".btn-customized-mini2").toggleClass("paused");
		jQuery(".btn-customized-mini2 i")
			.removeClass("fa-pause")
			.addClass("fa-play");
		jQuery(this).blur();
	} else {
		// jQuery('#carousel').carousel('cycle');
		crsl.carousel("cycle");
		jQuery(".btn-customized-mini2").toggleClass("paused");
		jQuery(".btn-customized-mini2 i")
			.removeClass("fa-play")
			.addClass("fa-pause");
		jQuery(this).blur();
	}
});
// Mini Slider 3
jQuery("#startStopMS3").on("click", function () {
	console.log("clicked");
	let crsl = jQuery("#carouselM3").carousel();
	if (!jQuery(this).hasClass("paused")) {
		// jQuery('.carousel').carousel( );
		crsl.carousel("pause");
		jQuery(".btn-customized-mini3").toggleClass("paused");
		jQuery(".btn-customized-mini3 i")
			.removeClass("fa-pause")
			.addClass("fa-play");
		jQuery(this).blur();
	} else {
		// jQuery('#carousel').carousel('cycle');
		crsl.carousel("cycle");
		jQuery(".btn-customized-mini3").toggleClass("paused");
		jQuery(".btn-customized-mini3 i")
			.removeClass("fa-play")
			.addClass("fa-pause");
		jQuery(this).blur();
	}
});

// Midi Slider
jQuery("#startStopMidi").on("click", function () {
	console.log("clicked");
	let crsl = jQuery("#carouselMidi").carousel();
	if (!jQuery(this).hasClass("paused")) {
		// jQuery('.carousel').carousel( );
		crsl.carousel("pause");
		jQuery(".btn-customized-midi").toggleClass("paused");
		jQuery(".btn-customized-midi i")
			.removeClass("fa-pause")
			.addClass("fa-play");
		jQuery(this).blur();
	} else {
		// jQuery('#carousel').carousel('cycle');
		crsl.carousel("cycle");
		jQuery(".btn-customized-midi").toggleClass("paused");
		jQuery(".btn-customized-midi i")
			.removeClass("fa-play")
			.addClass("fa-pause");
		jQuery(this).blur();
	}
});

jQuery(document).scroll(function () {
	let y = jQuery(this).scrollTop();
	if (y > window.innerHeight / 2.5) {
		// console.log(innerHeight);
		jQuery(".to-top2").show();
	} else {
		jQuery(".to-top2").hide();
	}
});
