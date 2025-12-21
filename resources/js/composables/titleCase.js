function titleCase(str) {
    if (typeof str !== 'string') return str;

    return str
        .trim()
        .toLowerCase()
        .replace(/[0-9]+/, '') // remove any non-alphanumeric characters and spaces
        .split(/\s+/)
        .map((w) => w[0].toUpperCase() + w.slice(1))
        .join(' ');
}
export { titleCase };
