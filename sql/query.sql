-- 초기화
ALTER TABLE "테이블명" AUTO_INCREMENT=1;
-- 오토넘버 추가
ALTER TABLE AMOUNT MODIFY no INT NOT NULL AUTO_INCREMENT PRIMARY KEY;

-- 테이블데이터 삭제
DELETE FROM `AMOUNT`



SELECT 
    COUNT(*) as total,
    COUNT(IF(status = 1 OR status = 2 OR status = 3 OR status = 4 OR status = 5 , 1, NULL)) as big_total,
    COUNT(IF(status = 1, 1, NULL)) as big_qutcall,
    COUNT(IF(status = 2, 1, NULL)) as big_completed,
    COUNT(IF(status = 3, 1, NULL)) as big_agree,
    COUNT(IF(status = 4, 1, NULL)) as big_not_agree,
    COUNT(IF(status = 5, 1, NULL)) as big_cancel,
    COUNT(IF(status = 6, 1, NULL)) as in_introduction,
    COUNT(IF(status = 7, 1, NULL)) as in_internet,
    COUNT(IF(status = 8, 1, NULL)) as in_other,
    SUM(cost) as total_cost,
    SUM(IF(status = 1 OR status = 2 OR status = 3 OR status = 4 OR status = 5 , cost, 0)) as big_total_cost,
    SUM(CASE WHEN status = 1 THEN cost ELSE 0 END) as big_outcall_cost,
    SUM(CASE WHEN status = 2 THEN cost ELSE 0 END) as big_completed_cost,
    SUM(CASE WHEN status = 3 THEN cost ELSE 0 END) as big_agree_cost,
    SUM(CASE WHEN status = 4 THEN cost ELSE 0 END) as big_not_agree_cost,
    SUM(CASE WHEN status = 5 THEN cost ELSE 0 END) as big_cancel_cost,
    SUM(CASE WHEN status = 6 THEN cost ELSE 0 END) as in_introduction_cost,
    SUM(CASE WHEN status = 7 THEN cost ELSE 0 END) as in_internet_cost,
    SUM(CASE WHEN status = 8 THEN cost ELSE 0 END) as in_other_cost
FROM (SELECT *, COUNT(userPhone) FROM VISIT GROUP BY userPhone HAVING COUNT(userPhone) >= 1 ORDER BY cost DESC) NEW_VISIT;

SELECT SUM(NEW_VISIT.d_count) as '중복포함', COUNT(NEW_VISIT.no) as '중복제외', SUM(NEW_VISIT.d_count)-COUNT(NEW_VISIT.no) as '중복수' FROM 
(SELECT *, COUNT(userPhone) AS d_count FROM VISIT GROUP BY userPhone HAVING COUNT(userPhone) >= 1 ORDER BY cost DESC) NEW_VISIT;

SELECT `visitDate` AS '날짜', `userName` AS '이름', `userPhone` AS '연락처', COUNT(userPhone) AS '중복수' FROM VISIT GROUP BY userPhone HAVING COUNT(userPhone) >= 2 ORDER BY `visitDate` DESC;

SELECT `visitDate`, `userName`, `userPhone`, COUNT(userPhone) AS d_count FROM VISIT WHERE CHARACTER_LENGTH(`userName`) < 2 GROUP BY userPhone HAVING COUNT(userPhone) >= 1 ORDER BY `visitDate` DESC;

SELECT * FROM VISIT WHERE CHARACTER_LENGTH(`userName`) > 3;


SELECT COUNT(*) AS cnt FROM `VISIT`;
SELECT
r_VISIT.no AS no,
r_VISIT.visitDate AS visitDate,
r_VISIT.userName AS userName,
r_VISIT.userPhone AS userPhone,
r_VISIT.device AS device,
r_VISIT.ip AS ip,
r_VISIT.path AS path,
r_VISIT.status AS status,
IFNULL(r_AMOUNT.estimate, 0) AS estimate,
IFNULL(r_AMOUNT.payment, 0) AS payment
FROM
(SELECT * FROM `VISIT` GROUP BY `userPhone` ORDER BY `visitDate` DESC) AS r_VISIT
LEFT JOIN
(SELECT
userNo,
SUM(estimate) AS estimate,
SUM(payment) AS payment
FROM
AMOUNT GROUP BY `userNo`) AS r_AMOUNT
ON r_VISIT.no = r_AMOUNT.userNo WHERE `no` = 1;

SELECT
userNo,
SUM(estimate) AS estimate,
SUM(payment) AS payment
FROM
AMOUNT GROUP BY `userNo`

SELECT * FROM `VISIT`
SELECT * FROM `RECALL`
SELECT * comment