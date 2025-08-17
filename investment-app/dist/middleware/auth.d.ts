import { Request, Response, NextFunction } from 'express';
export interface JwtPayload {
    userId: string;
    role: 'ADMIN' | 'INVESTOR';
}
export declare function authRequired(req: Request, res: Response, next: NextFunction): void | Response<any, Record<string, any>>;
export declare function requireRole(roles: Array<'ADMIN' | 'INVESTOR'>): (req: Request, res: Response, next: NextFunction) => Response<any, Record<string, any>> | undefined;
//# sourceMappingURL=auth.d.ts.map