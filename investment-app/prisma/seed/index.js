"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
const bcryptjs_1 = __importDefault(require("bcryptjs"));
const prisma_1 = require("../../src/config/prisma");
async function main() {
    const adminEmail = 'admin@example.com';
    const investorEmail = 'investor1@example.com';
    const admin = await prisma_1.prisma.user.upsert({
        where: { email: adminEmail },
        update: {},
        create: {
            email: adminEmail,
            passwordHash: await bcryptjs_1.default.hash('Admin@123', 10),
            name: 'Administrator',
            role: 'ADMIN'
        }
    });
    const investorUser = await prisma_1.prisma.user.upsert({
        where: { email: investorEmail },
        update: {},
        create: {
            email: investorEmail,
            passwordHash: await bcryptjs_1.default.hash('Investor@123', 10),
            name: 'Investor Satu',
            role: 'INVESTOR',
            investorProfile: {
                create: {
                    address: 'Jl. Mawar No. 1',
                    bankName: 'BCA',
                    nationalIdNumber: '1234567890',
                    kycStatus: 'VERIFIED',
                    kycVerifiedAt: new Date(),
                    kycVerifiedById: admin.id
                }
            }
        }
    });
    await prisma_1.prisma.investmentTransaction.create({
        data: {
            investorId: investorUser.investorProfile.id,
            type: 'DEPOSIT',
            amount: 100000000.0,
            note: 'Initial capital',
            approvedById: admin.id
        }
    });
    await prisma_1.prisma.dividendPeriod.upsert({
        where: { id: 'seed-period-1' },
        update: {},
        create: {
            id: 'seed-period-1',
            label: '2025-01',
            startDate: new Date('2025-01-01'),
            endDate: new Date('2025-01-31'),
            totalProfit: 5000000.0
        }
    });
    console.log('Seed complete:', { admin: admin.email, investor: investorUser.email });
}
main().finally(async () => {
    await prisma_1.prisma.$disconnect();
});
//# sourceMappingURL=index.js.map