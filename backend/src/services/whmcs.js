import { http } from '../utils/http.js';

function buildParams(action, params = {}) {
  const base = {
    identifier: process.env.WHMCS_IDENTIFIER,
    secret: process.env.WHMCS_SECRET,
    responsetype: 'json',
    action,
  };

  return new URLSearchParams({ ...base, ...params }).toString();
}

function requireEnv(value, name) {
  if (!value) {
    throw new Error(`Missing required environment variable: ${name}`);
  }
  return value;
}

const endpoint = () => requireEnv(process.env.WHMCS_URL, 'WHMCS_URL');

export async function fetchHostingPlans(category) {
  const response = await http.post(
    endpoint(),
    buildParams('GetProducts', {
      gid: category,
      module: true,
    }),
    {
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    }
  );

  if (response.data?.result !== 'success') {
    throw new Error(response.data?.message || 'Unable to fetch plans');
  }

  const products = response.data.products?.product || [];

  return products.map((product) => ({
    id: product.pid,
    product_id: product.pid,
    name: product.name,
    description: product.description?.replace(/<[^>]+>/g, '') ?? '',
    price: product.pricing?.USD?.monthly
      ? `$${Number(product.pricing.USD.monthly).toFixed(2)}`
      : null,
    features: product.features ? Object.values(product.features) : [],
    billingcycles: product.pricing?.USD ?? {},
    orderUrl: `${process.env.WHMCS_ORDER_BASE_URL || 'https://billing.virtualskyhost.com/cart.php'}?a=add&pid=${product.pid}`,
  }));
}

export async function fetchPlanCategories() {
  const response = await http.post(
    endpoint(),
    buildParams('GetProductGroups'),
    {
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    }
  );

  if (response.data?.result !== 'success') {
    throw new Error(response.data?.message || 'Unable to fetch categories');
  }

  return response.data.productgroups?.productgroup?.map((group) => ({
    id: group.gid,
    name: group.name,
  })) || [];
}

export async function searchDomain(domain) {
  const response = await http.post(
    endpoint(),
    buildParams('DomainWhois', { domain }),
    {
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    }
  );

  if (response.data?.result !== 'success') {
    throw new Error(response.data?.message || 'Unable to search domain');
  }

  return {
    domain,
    available: response.data.status === 'available',
    status: response.data.status,
  };
}

export async function createOrder(payload) {
  const response = await http.post(
    endpoint(),
    buildParams('AddOrder', payload),
    {
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    }
  );

  if (response.data?.result !== 'success') {
    return {
      success: false,
      message: response.data?.message || 'Unable to create order',
    };
  }

  return {
    success: true,
    orderid: response.data.orderid,
    invoiceid: response.data.invoiceid,
    productids: response.data.productids,
  };
}
