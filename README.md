# 📄 Invoice Management API

A Laravel-based **Invoice Management API** built with a clean layered architecture and solid OOP principles.  
This module is part of a real estate platform that manages contracts, invoices, taxes, and payments.

## 🚀 Tech Stack

- **Framework:** Laravel 10+
- **Language:** PHP 8.1+
- **Architecture:** DTO → Form Request → Controller → Policy → Service → Repository
- **Database:** MySQL / PostgreSQL
- **Design Principles:** SOLID, Clean Architecture, OOP
- **Patterns Used:**
  - Strategy Pattern (Tax Calculation)
  - Repository Pattern
  - Service Layer Pattern
  - Policy-based Authorization

---

## 📌 Features

### ✅ Contracts
- Multi-tenant aware
- Status management (`draft`, `active`, `expired`, `terminated`)

### ✅ Invoices
- Auto-generated invoice numbers
- Tax calculation via strategy pattern
- Status tracking (`pending`, `paid`, `partially_paid`, `overdue`, `cancelled`)
- Remaining balance calculation

### ✅ Payments
- Multiple payment methods:
  - Cash
  - Bank Transfer
  - Credit Card
- Prevent overpayments
- Automatic invoice status updates

### ✅ Financial Summary
- Total invoiced
- Total paid
- Outstanding balance
- Latest invoice date

---

## 🏗 Architecture Overview

HTTP Request  
↓  
Form Request (Validation)  
↓  
Controller (DTO creation + Authorization)  
↓  
Policy (Tenant authorization)  
↓  
Service (Business logic & transactions)  
↓  
Repository (Database access)  
↓  
API Resource (JSON response)

---

## 📂 Project Structure

```

app/
 └── Domain/
      ├── Contracts/
      │    ├── Enums/
      │    ├── Models/
      │    ├── Policies/
      │    └── Repositories/
      │
      ├── Invoices/
      │    ├── DTOs/
      |    ├── Enums/
      │    ├── Models/
      │    ├── Policies/
      │    ├── Repositories/
      │    └── Services/
      │
      ├── Payments/
      │    ├── DTOs/
      |    ├── Enums/
      │    ├── Models/
      │    ├── Policies/
      │    └── Repositories/
      │
      ├──Tax/
      |    ├── Interfaces/
      |    ├── Services/
      |    └── Strategies.php
      ├── Tenants/
      │    └── Models/
      └── Users/
      │    ├── DTOs/
      │    ├── Models/
      │    ├── Repositories/
      │    └── Services/

app/Http/
 ├── Controllers/
 └── Requests/
 └── Requests/


```

---

## 🧾 Domain Models

### Contract
| Field | Type |
|------|------|
| id | bigint |
| tenant_id | bigint |
| unit_name | string |
| customer_name | string |
| rent_amount | decimal |
| start_date | date |
| end_date | date |
| status | enum |

### Invoice
| Field | Type |
|------|------|
| id | bigint |
| contract_id | bigint |
| invoice_number | string |
| subtotal | decimal |
| tax_amount | decimal |
| total | decimal |
| status | enum |
| due_date | date |
| paid_at | datetime |

### Payment
| Field | Type |
|------|------|
| id | bigint |
| invoice_id | bigint |
| amount | decimal |
| payment_method | enum |
| reference_number | string |
| paid_at | datetime |

---

## 💰 Tax Calculation System

Implements the **Strategy Pattern** for flexible tax rules.

### Supported Taxes
- VAT → 15%
- Municipal Fee → 2.5%

### Adding a New Tax

1. Create a class implementing `TaxCalculatorInterface`
2. Register it in `TaxServiceProvider`

No existing code changes required ✅

---

## 🔢 Invoice Number Format

INV-{TENANT_ID}-{YYYYMM}-{SEQUENCE}  
Example: INV-001-202602-0001

---

## 🔐 Authorization Rules

Policies ensure tenant isolation:

- Users can only access data within their tenant
- Cannot create invoices for other tenants
- Cannot record payments on cancelled invoices

---

## 📡 API Endpoints

### ➤ Create Invoice
POST /api/contracts/{id}/invoices

### ➤ List Contract Invoices
GET /api/contracts/{id}/invoices

### ➤ Get Invoice Details
GET /api/invoices/{id}

### ➤ Record Payment
POST /api/invoices/{id}/payments

### ➤ Contract Financial Summary
GET /api/contracts/{id}/summary

---

## 🧠 Business Rules

- Invoice can only be created for **active contracts**
- Payments cannot exceed remaining balance
- Invoice status updates automatically:
  - Fully paid → `paid`
  - Partial payment → `partially_paid`
- All operations run inside **database transactions**

---

## ▶️ Installation

```bash
git clone https://github.com/your-username/invoice-management-api.git
cd invoice-management-api

composer install
cp .env.example .env
php artisan key:generate

php artisan migrate --seed
php artisan serve
```



---

## 📬 Example API Response

### Invoice Resource

```json
{
  "id": 1,
  "invoice_number": "INV-001-202602-0001",
  "subtotal": "1000.00",
  "tax_amount": "175.00",
  "total": "1175.00",
  "status": "pending",
  "due_date": "2026-03-01",
  "remaining_balance": "1175.00",
  "payments": []
}
```

---

## 🔐 Demo Access

**Email:** test@example.com  
**Password:** password  

> ⚠️ Demo credentials for testing only.

---

## 📮 Postman Collection

https://api.postman.com/collections/17254939-82c9b2a0-5dd4-446f-98ca-85d8f9f4ac3c?access_key=PMAT-01KJFQDDH7ZQ5R10SSY8BAGA4M

---
## 👩‍💻 Author

**Aya Ashraf**  
Laravel Backend Developer
