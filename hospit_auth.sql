/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : 127.0.0.1:3306
 Source Schema         : yaoshi

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 07/05/2020 10:34:44
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for hospit_auth
-- ----------------------------
DROP TABLE IF EXISTS `hospit_auth`;
CREATE TABLE `hospit_auth`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '菜单标题',
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '链接地址(控制器/方法)',
  `is_menu` tinyint(1) NULL DEFAULT NULL COMMENT '是否是菜单项 1不是 2是',
  `menu_icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '0' COMMENT '顶级节点图标(layui图标)',
  `pid` int(11) NULL DEFAULT NULL COMMENT '上级菜单id',
  `level` tinyint(1) NULL DEFAULT NULL COMMENT '层级 1项目 2模块 3操作',
  `sort` tinyint(1) NULL DEFAULT NULL COMMENT '排序',
  `status` tinyint(1) NULL DEFAULT 0 COMMENT '状态 0启用，1禁用',
  `create_time` int(11) NULL DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '医院权限列表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of hospit_auth
-- ----------------------------
INSERT INTO `hospit_auth` VALUES (2, '处方汇总', 'home/presc/index', 2, '', 0, 2, 4, 0, 1588750197);
INSERT INTO `hospit_auth` VALUES (3, '药品管理', 'home/drug/index', 2, 'ofmedkit', 0, 2, 2, 0, 1588727977);
INSERT INTO `hospit_auth` VALUES (4, '控制台', 'home/index/main', 2, 'bar-chart', 0, 2, 1, 0, 1588728314);
INSERT INTO `hospit_auth` VALUES (5, '添加药品', 'home/drug/add', 1, '', 3, 3, 2, 0, 1588730662);
INSERT INTO `hospit_auth` VALUES (6, 'Excel上传', 'home/drug/uploadExcel', 1, '', 3, 3, 2, 0, 1588730833);
INSERT INTO `hospit_auth` VALUES (8, '删除药品', '/home/drug/del', 1, '', 3, 3, 2, 0, 1588817668);
INSERT INTO `hospit_auth` VALUES (9, '数据监控', '/home/index/main', 1, '', 4, 3, 1, 0, 1588817780);
INSERT INTO `hospit_auth` VALUES (10, '添加处方', '/home/presc/add', 1, '', 2, 3, 4, 0, 1588817829);

SET FOREIGN_KEY_CHECKS = 1;
