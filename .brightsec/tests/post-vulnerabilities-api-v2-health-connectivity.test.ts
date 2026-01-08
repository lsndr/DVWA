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

test('POST /vulnerabilities/api/v2/health/connectivity', { signal: AbortSignal.timeout(timeout) }, async () => {
  await runner
    .createScan({
      tests: ['osi', 'ssrf', 'xss', 'csrf'],
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
      url: `${baseUrl}/vulnerabilities/api/v2/health/connectivity`,
      body: {
        target: 'digi.ninja'
      },
      headers: { 'Content-Type': 'application/json' }
    });
});