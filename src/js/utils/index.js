import isMobile from 'ismobilejs';

export function debounce(delay, fn) {
	let timerId;
	return (...args) => {
		if (timerId) {
			clearTimeout(timerId);
		}
		timerId = setTimeout(() => {
			fn(...args);
			timerId = null;
		}, delay);
	};
}

export function debounceImmediate(delay, fn) {
	let fired = false;
	return (...args) => {
		if (!fired) {
			fn(...args);
			fired = true;
			setTimeout(() => {
				fired = false;
			}, delay);
		}
	};
}

export const calcViewportHeight = () => {
	const isMobileData = isMobile();
	const isApple = isMobileData.apple.phone;
	const isAndroid = isMobileData.android.phone;
	const isSeven = isMobileData.seven_inch;

	if (isApple || isAndroid || isSeven) {
		const vh = window.innerHeight * 0.01;
		// console.log(vh);
		document.documentElement.style.setProperty('--vh', `${vh}px`);
	}
};

export const calcRemValue = ({
	windowWidth,
	windowHeight,
}) => {
	const remValue = windowWidth * 0.5625 > windowHeight ? (windowHeight / 800) * 10 : (windowWidth / 1440) * 10;

	document.documentElement.style.setProperty('--rem', `${remValue}px`);
};

export const calcMobileRemValue = ({ windowHeight }) => {
	const mobileRemValue = (windowHeight / 800) * 10;

	document.documentElement.style.setProperty('--mobile-rem', `${mobileRemValue}px`);
};

export const getRandomInt = (min, max) => {
	return Math.floor(Math.random() * (max - min)) + min;
};

export const getRandom = (min, max) => {
	return Math.random() * (max - min) + min;
};

export function isFunction(func) {
	return func instanceof Function;
}

export function getWindowSize() {
	const windowWidth = window.innerWidth;
	const windowHeight = window.innerHeight;

	return {
		windowWidth,
		windowHeight,
	};
}

export const onWindowResize = cb => {
	if (!cb && !isFunction(cb)) return;

	const handleResize = () => {
		cb();
	};

	window.addEventListener('resize', debounce(15, handleResize));

	handleResize();
};

export const onWindowScroll = cb => {
	if (!cb && !isFunction(cb)) return;

	const handleScroll = () => {
		cb(window.pageYOffset);
	};

	window.addEventListener('scroll', debounce(15, handleScroll));

	handleScroll();
};

export const documentReady = cb => {
	if (!cb && !isFunction(cb)) return;
	document.addEventListener('DOMContentLoaded', cb);
};


export const jqDocumentReady = cb => {
	if (!cb && !isFunction(cb)) return;
	jQuery( document ).ready(cb);
};

export const pageLoad = cb => {
	if (!cb && !isFunction(cb)) return;
	window.addEventListener('load', cb);
};
