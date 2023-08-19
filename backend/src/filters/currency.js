export default function currencyUSD(value) {
  return new Intl.NumberFormat('en-IN', {style: 'currency', currency: 'NPR'})
    .format(value);
}
