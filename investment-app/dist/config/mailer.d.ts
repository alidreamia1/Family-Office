import nodemailer from 'nodemailer';
export declare const mailTransport: nodemailer.Transporter<import("nodemailer/lib/smtp-transport").SentMessageInfo, import("nodemailer/lib/smtp-transport").Options>;
export declare function sendMail(options: {
    to: string;
    subject: string;
    html?: string;
    text?: string;
    from?: string;
}): Promise<import("nodemailer/lib/smtp-transport").SentMessageInfo>;
//# sourceMappingURL=mailer.d.ts.map