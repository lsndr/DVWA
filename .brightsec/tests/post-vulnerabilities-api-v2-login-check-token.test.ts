import { test, before, after } from 'node:test';
import { SecRunner } from '@sectester/runner';
import { AttackParamLocation, HttpMethod } from '@sectester/scan';

const timeout = 40 * 60 * 1000;
const baseUrl = process.env.BRIGHT_TARGET_URL!;

let runner!: SecRunner;

before(async () => {
  runner = new SecRunner({
    hostname: process.env.BRIGHT_HOSTNAME!,
    projectId: process.env.BRIGHT_PROJECT_ID!
  });

  await runner.init();
});

after(() => runner.clear());

test('POST /vulnerabilities/api/v2/login/check_token', { signal: AbortSignal.timeout(timeout) }, async () => {
  await runner
    .createScan({
      tests: ['csrf', 'secret_tokens', 'xss', 'sqli', 'osi'],
      attackParamLocations: [AttackParamLocation.BODY],
      starMetadata: {
        code_source: 'lsndr/DVWA:master',
        databases: ['MySQL'],
        user_roles: {
          roles: ['admin']
        }
      },
      poolSize: +process.env.SECTESTER_SCAN_POOL_SIZE || undefined
    })
    .setFailFast(false)
    .timeout(timeout)
    .run({
      method: HttpMethod.POST,
      url: `${baseUrl}/vulnerabilities/api/v2/login/check_token`,
      body: {
        token: '11111'
      },
      headers: { 'Content-Type': 'application/json' }
    });
});