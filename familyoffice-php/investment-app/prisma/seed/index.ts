import bcrypt from 'bcryptjs';
import { prisma } from '../../src/config/prisma';

async function main() {
	const adminEmail = 'admin@example.com';
	const investorEmail = 'investor1@example.com';

	const admin = await prisma.user.upsert({
		where: { email: adminEmail },
		update: {},
		create: {
			email: adminEmail,
			passwordHash: await bcrypt.hash('Admin@123', 10),
			name: 'Administrator',
			role: 'ADMIN'
		}
	});

	const investorUser = await prisma.user.upsert({
		where: { email: investorEmail },
		update: {},
		create: {
			email: investorEmail,
			passwordHash: await bcrypt.hash('Investor@123', 10),
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

	await prisma.investmentTransaction.create({
		data: {
			investorId: investorUser.investorProfile!.id,
			type: 'DEPOSIT',
			amount: 100000000.0,
			note: 'Initial capital',
			approvedById: admin.id
		}
	});

	await prisma.dividendPeriod.upsert({
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
	await prisma.$disconnect();
});