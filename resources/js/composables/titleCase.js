function titleCase(str) {
    if (typeof str !== 'string') return str;

    return str
        .trim()
        .toLowerCase()
        .split(/\s+/)
        .map((w) => w[0].toUpperCase() + w.slice(1))
        .join(' ');
}
export { titleCase };
