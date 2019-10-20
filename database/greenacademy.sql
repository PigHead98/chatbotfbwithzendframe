/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100315
 Source Host           : localhost:3306
 Source Schema         : greenacademy

 Target Server Type    : MySQL
 Target Server Version : 100315
 File Encoding         : 65001

 Date: 16/07/2019 17:01:13
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for contact
-- ----------------------------
DROP TABLE IF EXISTS `contact`;
CREATE TABLE `contact`  (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `phone` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of contact
-- ----------------------------
INSERT INTO `contact` VALUES (1, '2', '3', '4');
INSERT INTO `contact` VALUES (2, 'Name', 'reystay', '123');
INSERT INTO `contact` VALUES (3, 'Name1', 'reystay1', '1232');
INSERT INTO `contact` VALUES (4, 'ÄÃ o TrÆ°á»ng An', 'reystay.rz@gmail.com', '1634217575');

SET FOREIGN_KEY_CHECKS = 1;
