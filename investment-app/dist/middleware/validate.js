"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.handleValidation = handleValidation;
const express_1 = require("express");
const express_validator_1 = require("express-validator");
function handleValidation(req, res, next) {
    const result = (0, express_validator_1.validationResult)(req);
    if (!result.isEmpty()) {
        return res.status(422).json({ errors: result.array() });
    }
    next();
}
//# sourceMappingURL=validate.js.map