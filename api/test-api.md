# CA Manufacturing CMS API Documentation

## Overview

This API allows the Warehouse Management System (WMS) to access SKU data from the CA Manufacturing CMS.  

---

## Authentication

Include your API key in the request header:

```
X-API-KEY: sir-4d-api-2026
```

---

## Endpoints

### 1. Get SKU by ID

**Endpoint:**  
`GET /api/test.php?id={sku_id}`

**Description:**  
Returns details for a single SKU.

**Request Example:**
```http
GET /api/test.php?id=1
X-API-KEY: sir-api-key-2026
```

**Response Example:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "ficha": 452,
    "sku": "1720823-0567",
    "description": "BIRCH YEL FAS 6/4 RGH KD 10FT",
    "uom": "PALLET",
    "pieces": 95,
    "length_inches": "120",
    "width_inches": "44",
    "height_inches": "34",
    "weight_lbs": "3120",
  }
}
```

**Error Responses:**
- Missing ID:
    ```json
    {
      "error": "Bad Request",
      "details": "Missing SKU ID"
    }
    ```
- SKU Not Found:
    ```json
    {
      "error": "SKU not found"
    }
    ```

---

## Example Usage

You can test the endpoint using tools like [Yaak](https://yaak.app), Postman, or curl:

```bash
curl -H "X-API-KEY: your-api-key" "https://your-domain/api/test.php?id=1"
