<?php
	function into_tree_courseware($value, $field){
		$tree = array();

		foreach ($value as $val) {
			$tree[$val->uc_parent][] = array(
											'uc'				=> $val->uc,
											$field				=> $val->$field,
											'uc_parent'			=> $val->uc_parent,
											'type'				=> $val->type,
											'level'				=> $val->level,
											'code'				=> $val->code,
											'path'				=> $val->path,
											'seq'				=> $val->seq,
											'seq_system'		=> $val->seq_system,
											'uc_training' 		=> $val->uc_training
											);
		}

		$tree['last_seq_system'] = end($value)->seq_system; // For last key

		return $tree;

	}

	function tree_checked($value, $field){
		$tree = array();

		foreach ($value as $val) {
			$tree[$val->uc_parent][] = array(
											'uc'		=> $val->uc,
											$field		=> $val->$field,
											'uc_parent'	=> $val->uc_parent,
											'type'		=> $val->type,
											'level'		=> $val->level,
											'key'		=> $val->key,
											'code'		=> $val->code,
											'path'		=> $val->path
											);
		}

		return $tree;
	}

	function tree_courseware_browse($tree, $uc_parent) {		
		for ($i = 0; $i < count($tree[$uc_parent]); $i++) {

			$tree_class = "treegrid-".$tree[$uc_parent][$i]['uc'];
			if ($tree[$uc_parent][$i]['uc_parent'] != 0) {
				$tree_class .= " treegrid-parent-".$tree[$uc_parent][$i]['uc_parent'];
			}

			echo "<tr class='".$tree_class."'>";
					if ($tree[$uc_parent][$i]['type'] == 0) {
						echo "<td width='275'><img src='".base_url('assets/image/ico-structure.png')."' width='15' height='15' style='margin:0px 5px 0px 5px;' /><a href='#' class='tree courseware-list' uc='".$tree[$uc_parent][$i]['uc']."'>".$tree[$uc_parent][$i]['code']."-".$tree[$uc_parent][$i]['label']."</a><div style='float:right;'><img class='add-ico add-child' src='".base_url('assets/image/ico-add.png')."' title='Add Child for (".$tree[$uc_parent][$i]['label'].")' uc='".$tree[$uc_parent][$i]['uc']."' /><img class='edit-ico edit' src='".base_url('assets/image/ico-edit.png')."' title='Edit folder (".$tree[$uc_parent][$i]['label'].")..??' uc='".$tree[$uc_parent][$i]['uc']."' /><img class='delete-ico delete' src='".base_url('assets/image/ico-delete.png')."' title='Delete folder (".$tree[$uc_parent][$i]['label'].")!!' uc='".$tree[$uc_parent][$i]['uc']."' /></div></td>";
					} else if ($tree[$uc_parent][$i]['type'] == 1) {
						echo "<td width='275'><img src='".base_url('assets/image/ico-content.png')."' width='15' height='15' style='margin:0px 5px 0px 5px;' /><a href='#' class='tree courseware-list-content' uc='".$tree[$uc_parent][$i]['uc']."'>".$tree[$uc_parent][$i]['code']."-".$tree[$uc_parent][$i]['label']."</a><div style='float:right;'><img class='edit-ico edit' src='".base_url('assets/image/ico-edit.png')."' title='Edit folder (".$tree[$uc_parent][$i]['label'].")..??' uc='".$tree[$uc_parent][$i]['uc']."' /><img class='delete-ico delete-content' src='".base_url('assets/image/ico-delete.png')."' title='Delete folder (".$tree[$uc_parent][$i]['label'].")!!' uc='".$tree[$uc_parent][$i]['uc']."' /></div></td>";
					}
			echo "</tr>";

			if (count(@$tree[$tree[$uc_parent][$i]['uc']]) > 0) {
				tree_courseware_browse($tree, $tree[$uc_parent][$i]['uc']);
			}
			
		}
	}

	function tree_courseware_selecting($tree, $uc_parent) {
		for ($i = 0; $i < count($tree[$uc_parent]); $i++) {

			$tree_class = "treegrid-".$tree[$uc_parent][$i]['uc'];
			if ($tree[$uc_parent][$i]['uc_parent'] != 0) {
				$tree_class .= " treegrid-parent-".$tree[$uc_parent][$i]['uc_parent'];
			}

			echo "<tr class='".$tree_class."'>";
					if ($tree[$uc_parent][$i]['type'] == 0) {
						echo "<td><img src='".base_url('assets/image/ico-structure.png')."' width='15' height='15' style='margin:0px 5px 0px 5px;' /><label style='margin:0px 10px 0px 5px;>".$tree[$uc_parent][$i]['code']."-".$tree[$uc_parent][$i]['label']."</label></td>";
					} else if ($tree[$uc_parent][$i]['type'] == 1) {
						echo "<td><img src='".base_url('assets/image/ico-content.png')."' width='15' height='15' style='margin:0px 5px 0px 5px;' /><input type='radio' name='f_topic' label='".$tree[$uc_parent][$i]['label']."' uc-parent='".$tree[$uc_parent][$i]['uc_parent']."' value='".$tree[$uc_parent][$i]['uc']."' />".$tree[$uc_parent][$i]['code']."-".$tree[$uc_parent][$i]['label']."</td>";
					}
			echo "</tr>";

			if (count(@$tree[$tree[$uc_parent][$i]['uc']]) > 0) {
				tree_courseware_selecting($tree, $tree[$uc_parent][$i]['uc']);
			}

		}
	}

	function tree_courseware_pick($tree, $uc_parent) {
		for ($i = 0; $i < count($tree[$uc_parent]); $i++) {

			$tree_class = "treegrid-".$tree[$uc_parent][$i]['uc'];
			if ($tree[$uc_parent][$i]['uc_parent'] != 0) {
				$tree_class .= " treegrid-parent-".$tree[$uc_parent][$i]['uc_parent'];
			}

			echo "<tr class='".$tree_class."'>";
					if ($tree[$uc_parent][$i]['type'] == 0) {
						echo "<td><img src='".base_url('assets/image/ico-structure.png')."' width='15' height='15' style='margin:0px 5px 0px 5px;' /><input type='checkbox' name='f_structure[]' class='check-structure' value='".$tree[$uc_parent][$i]['uc']."' uc-parent='".$tree[$uc_parent][$i]['uc_parent']."' />".$tree[$uc_parent][$i]['code']."-".$tree[$uc_parent][$i]['label']."</td>";
					} else if ($tree[$uc_parent][$i]['type'] == 1) {
						echo "<td><img src='".base_url('assets/image/ico-content.png')."' width='15' height='15' style='margin:0px 5px 0px 5px;' /><input type='checkbox' name='f_content[]' value='".$tree[$uc_parent][$i]['uc']."' uc-parent='".$tree[$uc_parent][$i]['uc_parent']."' />".$tree[$uc_parent][$i]['code']."-".$tree[$uc_parent][$i]['label']."</td>";
					}
			echo "</tr>";

			if (count(@$tree[$tree[$uc_parent][$i]['uc']]) > 0) {
				tree_courseware_pick($tree, $tree[$uc_parent][$i]['uc']);
			}

		}
	}

	function courseware_pick($tree, $uc_parent) {
		for ($i = 0; $i < count($tree[$uc_parent]); $i++) {

			$tree_class = "treegrid-".$tree[$uc_parent][$i]['uc'];
			if ($tree[$uc_parent][$i]['uc_parent'] != 0) {
				$tree_class .= " treegrid-parent-".$tree[$uc_parent][$i]['uc_parent'];
			}

			echo "<tr class='".$tree_class."'>";
					if ($tree[$uc_parent][$i]['type'] == 0) {
						echo "<td title='".$tree[$uc_parent][$i]['label']."'><img src='".base_url('assets/image/ico-structure.png')."' width='15' height='15' style='margin:0px 5px 0px 5px;' /><input ".disabled($tree[$uc_parent][$i]['uc'], $tree[$uc_parent][$i]['key'])." ".check_set($tree[$uc_parent][$i]['uc'],$tree[$uc_parent][$i]['key'])." type='checkbox' name='f_pick[]' class='check-structure' value='".$tree[$uc_parent][$i]['uc']."' uc-parent='".$tree[$uc_parent][$i]['uc_parent']."' /><label class='label-folder'>".$tree[$uc_parent][$i]['code']."-".$tree[$uc_parent][$i]['label']."</label></td>";
					} else if ($tree[$uc_parent][$i]['type'] == 1) {
						echo "<td title='".$tree[$uc_parent][$i]['label']."'><img src='".base_url('assets/image/ico-content.png')."' width='15' height='15' style='margin:0px 5px 0px 5px;' /><input ".disabled($tree[$uc_parent][$i]['uc'], $tree[$uc_parent][$i]['key'])." ".check_set($tree[$uc_parent][$i]['uc'],$tree[$uc_parent][$i]['key'])." type='checkbox' name='f_pick[]' value='".$tree[$uc_parent][$i]['uc']."' uc-parent='".$tree[$uc_parent][$i]['uc_parent']."' /><label class='label-folder'>".$tree[$uc_parent][$i]['code']."-".$tree[$uc_parent][$i]['label']."</label></td>";
					}
			echo "</tr>";

			if (count(@$tree[$tree[$uc_parent][$i]['uc']]) > 0) {
				courseware_pick($tree, $tree[$uc_parent][$i]['uc']);
			}

		}
	}

	function pick_courseware($tree, $uc_parent) {
		// for ($i = 0; $i < count($tree[$uc_parent]); $i++) {

		// 	$tree_class = "treegrid-".$tree[$uc_parent][$i]['uc'];
		// 	if ($tree[$uc_parent][$i]['uc_parent'] != 0) {
		// 		$tree_class .= " treegrid-parent-".$tree[$uc_parent][$i]['uc_parent'];
		// 	}

		// 	echo "<tr class='".$tree_class."'>";

		// 			if ($tree[$uc_parent][$i]['type'] == 0) {
		// 				echo "<td title='".$tree[$uc_parent][$i]['label']."'><img src='".base_url('assets/image/ico-structure.png')."' width='15' height='15' style='margin:0px 5px 0px 5px;' /><input ".disabled($tree[$uc_parent][$i]['uc'], $tree[$uc_parent][$i]['key'])." ".check_set($tree[$uc_parent][$i]['uc'],$tree[$uc_parent][$i]['key'])." type='checkbox' name='f_pick[]' class='check-structure' value='".$tree[$uc_parent][$i]['path']."' uc-parent='".$tree[$uc_parent][$i]['uc_parent']."' /><label class='label-folder'>".$tree[$uc_parent][$i]['code']."-".$tree[$uc_parent][$i]['label']."</label></td>";
		// 			} else if ($tree[$uc_parent][$i]['type'] == 1) {
		// 				echo "<td title='".$tree[$uc_parent][$i]['label']."'><img src='".base_url('assets/image/ico-content.png')."' width='15' height='15' style='margin:0px 5px 0px 5px;' /><input ".disabled($tree[$uc_parent][$i]['uc'], $tree[$uc_parent][$i]['key'])." ".check_set($tree[$uc_parent][$i]['uc'],$tree[$uc_parent][$i]['key'])." type='checkbox' name='f_pick[]' value='".$tree[$uc_parent][$i]['path']."' uc-parent='".$tree[$uc_parent][$i]['uc_parent']."' /><label class='label-folder'>".$tree[$uc_parent][$i]['code']."-".$tree[$uc_parent][$i]['label']."</label></td>";
		// 			}

		// 	echo "</tr>";

		// 	if (count(@$tree[$tree[$uc_parent][$i]['uc']]) > 0) {
		// 		pick_courseware($tree, $tree[$uc_parent][$i]['uc']);
		// 	}

		// }

		for ($i = 0; $i < count($tree[$uc_parent]); $i++) {

			$tree_class = "treegrid-".$tree[$uc_parent][$i]['uc'];
			if ($tree[$uc_parent][$i]['uc_parent'] != 0) {
				$tree_class .= " treegrid-parent-".$tree[$uc_parent][$i]['uc_parent'];
			}

			echo "<tr class='".$tree_class."'>";
					if ($tree[$uc_parent][$i]['type'] == 0) {
						echo "<td title='".$tree[$uc_parent][$i]['label']."'><img src='".base_url('assets/image/ico-structure.png')."' width='15' height='15' style='margin:0px 5px 0px 5px;' /><input ".disabled($tree[$uc_parent][$i]['uc'], $tree[$uc_parent][$i]['key'])." ".check_set($tree[$uc_parent][$i]['uc'],$tree[$uc_parent][$i]['key'])." type='checkbox' name='f_pick[]' class='check-structure' value='".$tree[$uc_parent][$i]['path']."' uc-parent='".$tree[$uc_parent][$i]['uc_parent']."' /><label class='label-folder'>".$tree[$uc_parent][$i]['code']."-".$tree[$uc_parent][$i]['label']."</label></td>";
					} else if ($tree[$uc_parent][$i]['type'] == 1) {
						echo "<td title='".$tree[$uc_parent][$i]['label']."'><img src='".base_url('assets/image/ico-content.png')."' width='15' height='15' style='margin:0px 5px 0px 5px;' /><input ".disabled($tree[$uc_parent][$i]['uc'], $tree[$uc_parent][$i]['key'])." ".check_set($tree[$uc_parent][$i]['uc'],$tree[$uc_parent][$i]['key'])." type='checkbox' name='f_pick[]' value='".$tree[$uc_parent][$i]['path']."' uc-parent='".$tree[$uc_parent][$i]['uc_parent']."' /><label class='label-folder'>".$tree[$uc_parent][$i]['code']."-".$tree[$uc_parent][$i]['label']."</label></td>";
					}
			echo "</tr>";

			if (count(@$tree[$tree[$uc_parent][$i]['uc']]) > 0) {
				pick_courseware($tree, $tree[$uc_parent][$i]['uc']);
			}

		}
	}

	function courseware_select($tree, $uc_parent) {
		for ($i = 0; $i < count($tree[$uc_parent]); $i++) {

			$tree_class = "treegrid-".$tree[$uc_parent][$i]['uc'];
			if ($tree[$uc_parent][$i]['uc_parent'] != 0) {
				$tree_class .= " treegrid-parent-".$tree[$uc_parent][$i]['uc_parent'];
			}

			echo "<tr class='".$tree_class."'>";
					if ($tree[$uc_parent][$i]['type'] == 0) {
						echo "<td><img src='".base_url('assets/image/ico-structure.png')."' width='15' height='15' style='margin:0px 5px 0px 5px;' /><label style='margin:0px 10px 0px 5px;>".$tree[$uc_parent][$i]['code']."-".$tree[$uc_parent][$i]['label']."</label></td>";
					} else if ($tree[$uc_parent][$i]['type'] == 1) {
						echo "<td><img src='".base_url('assets/image/ico-content.png')."' width='15' height='15' style='margin:0px 5px 0px 5px;' /><input type='radio' name='f_topic' label='".$tree[$uc_parent][$i]['code']."-".$tree[$uc_parent][$i]['label']."' uc-parent='".$tree[$uc_parent][$i]['uc_parent']."' value='".$tree[$uc_parent][$i]['uc']."' />".$tree[$uc_parent][$i]['label']."</td>";
					}
			echo "</tr>";

			if (count(@$tree[$tree[$uc_parent][$i]['uc']]) > 0) {
				courseware_select($tree, $tree[$uc_parent][$i]['uc']);
			}

		}
	}

	function courseware_browse($tree, $uc_parent) {		
		for ($i = 0; $i < count($tree[$uc_parent]); $i++) {

			$tree_class = "treegrid-".$tree[$uc_parent][$i]['uc'];
			if ($tree[$uc_parent][$i]['uc_parent'] != 0) {
				$tree_class .= " treegrid-parent-".$tree[$uc_parent][$i]['uc_parent'];
			}

			echo "<tr class='".$tree_class."'>";
					if ($tree[$uc_parent][$i]['type'] == 0) {
						if ($tree[$uc_parent][$i]['level'] == 0) {
							if ($tree[$uc_parent][$i]['path']  != "") {
								if ($tree[$uc_parent][$i]['seq_system']  == 1) {
									if ($tree[$uc_parent][$i]['seq_system'] != $tree['last_seq_system']) {
										echo "<td width='275'><img src='".base_url('assets/image/ico-structure.png')."' width='15' height='15' style='margin:0px 5px 0px 5px;' /><a href='".base_url('training/get_delete_index/'.$tree[$uc_parent][$i]['uc'].'/'.$tree[$uc_parent][$i]['uc_training'])."' title='Delete System'> <img class='btn-delete-index' src='".base_url('assets/third_party/immu-ui/image/ico-trash.png')."' uc='".$tree[$uc_parent][$i]['uc']."' title='Delete' style='margin-left:5px; cursor:pointer;' /></a><img src='".base_url('assets/image/ico-arrow-down-original.png')."' width='15' height='15' style='transform: rotate(180deg); margin-left:10px; opacity:0.4;' /><a href='".base_url('training/change_seq_system/down/'.$tree[$uc_parent][$i]['uc_training'].'/'.$tree[$uc_parent][$i]['uc'])."' title='Down' style='margin:0px 10px 0px 0px; cursor:pointer;'><img src='".base_url('assets/image/ico-arrow-down-original.png')."' width='15' height='15' /></a><a href='#' class='tree btn-structure' level='".$tree[$uc_parent][$i]['level']."' uc='".$tree[$uc_parent][$i]['uc']."'>".$tree[$uc_parent][$i]['code']."-".$tree[$uc_parent][$i]['label']."</a></td>";
									} else {
										echo "<td width='275'><img src='".base_url('assets/image/ico-structure.png')."' width='15' height='15' style='margin:0px 5px 0px 5px;' /><a href='".base_url('training/get_delete_index/'.$tree[$uc_parent][$i]['uc'].'/'.$tree[$uc_parent][$i]['uc_training'])."' title='Delete System'> <img class='btn-delete-index' src='".base_url('assets/third_party/immu-ui/image/ico-trash.png')."' uc='".$tree[$uc_parent][$i]['uc']."' title='Delete' style='margin-left:5px; cursor:pointer;' /></a><img src='".base_url('assets/image/ico-arrow-down-original.png')."' width='15' height='15' style='transform: rotate(180deg); margin-left:10px; opacity:0.4;' /><img src='".base_url('assets/image/ico-arrow-down-original.png')."' width='15' height='15' style='margin:0px 10px 0px 0px; opacity:0.4;' /><a href='#' class='tree btn-structure' level='".$tree[$uc_parent][$i]['level']."' uc='".$tree[$uc_parent][$i]['uc']."'>".$tree[$uc_parent][$i]['code']."-".$tree[$uc_parent][$i]['label']."</a></td>";
									}
								} elseif ($tree[$uc_parent][$i]['seq_system'] == $tree['last_seq_system']) {
									echo "<td width='275'><img src='".base_url('assets/image/ico-structure.png')."' width='15' height='15' style='margin:0px 5px 0px 5px;' /><a href='".base_url('training/get_delete_index/'.$tree[$uc_parent][$i]['uc'].'/'.$tree[$uc_parent][$i]['uc_training'])."' title='Delete System'> <img class='btn-delete-index' src='".base_url('assets/third_party/immu-ui/image/ico-trash.png')."' uc='".$tree[$uc_parent][$i]['uc']."' title='Delete' style='margin-left:5px; cursor:pointer;' /></a><a href='".base_url('training/change_seq_system/up/'.$tree[$uc_parent][$i]['uc_training'].'/'.$tree[$uc_parent][$i]['uc'])."' title='Up' style='margin-left:10px; cursor:pointer;'><img src='".base_url('assets/image/ico-arrow-down-original.png')."' width='15' height='15' style='transform: rotate(180deg);' /></a><img src='".base_url('assets/image/ico-arrow-down-original.png')."' width='15' height='15' style='margin:0px 10px 0px 0px; cursor:pointer; opacity:0.4;' /><a href='#' class='tree btn-structure' level='".$tree[$uc_parent][$i]['level']."' uc='".$tree[$uc_parent][$i]['uc']."'>".$tree[$uc_parent][$i]['code']."-".$tree[$uc_parent][$i]['label']."</a></td>";
								} else {
									echo "<td width='275'><img src='".base_url('assets/image/ico-structure.png')."' width='15' height='15' style='margin:0px 5px 0px 5px;' /><a href='".base_url('training/get_delete_index/'.$tree[$uc_parent][$i]['uc'].'/'.$tree[$uc_parent][$i]['uc_training'])."' title='Delete System'> <img class='btn-delete-index' src='".base_url('assets/third_party/immu-ui/image/ico-trash.png')."' uc='".$tree[$uc_parent][$i]['uc']."' title='Delete' style='margin-left:5px; cursor:pointer;' /></a><a href='".base_url('training/change_seq_system/up/'.$tree[$uc_parent][$i]['uc_training'].'/'.$tree[$uc_parent][$i]['uc'])."' title='Up' style='margin-left:10px; cursor:pointer;'><img src='".base_url('assets/image/ico-arrow-down-original.png')."' width='15' height='15' style='transform: rotate(180deg);' /></a><a href='".base_url('training/change_seq_system/down/'.$tree[$uc_parent][$i]['uc_training'].'/'.$tree[$uc_parent][$i]['uc'])."' title='Down' style='margin:0px 10px 0px 0px; cursor:pointer;'><img src='".base_url('assets/image/ico-arrow-down-original.png')."' width='15' height='15' /></a><a href='#' class='tree btn-structure' level='".$tree[$uc_parent][$i]['level']."' uc='".$tree[$uc_parent][$i]['uc']."'>".$tree[$uc_parent][$i]['code']."-".$tree[$uc_parent][$i]['label']."</a></td>";
								}
							} else {
								echo "<td width='275'><img src='".base_url('assets/image/ico-structure.png')."' width='15' height='15' style='margin:0px 5px 0px 5px;' /><a href='#' class='tree btn-structure' level='".$tree[$uc_parent][$i]['level']."' uc='".$tree[$uc_parent][$i]['uc']."'>".$tree[$uc_parent][$i]['code']."-".$tree[$uc_parent][$i]['label']."</a></td>";	
							}
						} else {
							echo "<td width='275'><img src='".base_url('assets/image/ico-structure.png')."' width='15' height='15' style='margin:0px 5px 0px 5px;' /><a href='#' class='tree btn-structure' level='".$tree[$uc_parent][$i]['level']."' uc='".$tree[$uc_parent][$i]['uc']."'>".$tree[$uc_parent][$i]['code']."-".$tree[$uc_parent][$i]['label']."</a></td>";
						}
					} else if ($tree[$uc_parent][$i]['type'] == 1) {
						echo "<td width='275'><img src='".base_url('assets/image/ico-content.png')."' width='15' height='15' style='margin:0px 5px 0px 5px;' /><a href='#' class='tree btn-content' level='".$tree[$uc_parent][$i]['level']."' uc='".$tree[$uc_parent][$i]['uc']."'>".$tree[$uc_parent][$i]['code']."-".$tree[$uc_parent][$i]['label']."</a></td>";
					} else if($tree[$uc_parent][$i]['type'] == 2) {
						echo "<td width='275'><img src='".base_url('assets/image/ico-examination.png')."' width='15' height='15' style='margin:0px 5px 0px 5px;' /><a href='#' class='tree btn-exam' level='".$tree[$uc_parent][$i]['level']."' uc='".$tree[$uc_parent][$i]['uc']."'>".$tree[$uc_parent][$i]['label']."</a></td>";
					} else if($tree[$uc_parent][$i]['type'] == 3) {
						echo "<td width='275'><img src='".base_url('assets/image/ico-exercise.png')."' width='15' height='15' style='margin:0px 5px 0px 5px;' /><a href='#' class='tree btn-exec' level='".$tree[$uc_parent][$i]['level']."' uc='".$tree[$uc_parent][$i]['uc']."'>".$tree[$uc_parent][$i]['label']."</a></td>";
					}
			echo "</tr>";

			if (count(@$tree[$tree[$uc_parent][$i]['uc']]) > 0) {
				courseware_browse($tree, $tree[$uc_parent][$i]['uc']);
			}
			
		}
	}

	function courseware_browse_student($tree, $uc_parent) {		
		for ($i = 0; $i < count($tree[$uc_parent]); $i++) {

			$tree_class = "treegrid-".$tree[$uc_parent][$i]['uc'];
			if ($tree[$uc_parent][$i]['uc_parent'] != 0) {
				$tree_class .= " treegrid-parent-".$tree[$uc_parent][$i]['uc_parent'];
			}

			echo "<tr class='".$tree_class."'>";
					if ($tree[$uc_parent][$i]['type'] == 0) {
						echo "<td width='275'><img src='".base_url('assets/image/ico-structure.png')."' width='15' height='15' style='margin:0px 5px 0px 5px;' /><a href='#' class='tree btn-structure-student' seq-system='".$tree[$uc_parent][$i]['seq_system']."'  level='".$tree[$uc_parent][$i]['level']."' uc='".$tree[$uc_parent][$i]['uc']."'>".$tree[$uc_parent][$i]['code']."-".$tree[$uc_parent][$i]['label']."</a></td>";
					} else if ($tree[$uc_parent][$i]['type'] == 1) {
						echo "<td width='275'><img src='".base_url('assets/image/ico-content.png')."' width='15' height='15' style='margin:0px 5px 0px 5px;' /><a href='#' class='tree btn-content-student'  seq-content='".$tree[$uc_parent][$i]['seq']."' level='".$tree[$uc_parent][$i]['level']."' uc='".$tree[$uc_parent][$i]['uc']."'>".$tree[$uc_parent][$i]['code']."-".$tree[$uc_parent][$i]['label']."</a></td>";
					} else if($tree[$uc_parent][$i]['type'] == 2) {
						echo "<td width='275'><img src='".base_url('assets/image/ico-examination.png')."' width='15' height='15' style='margin:0px 5px 0px 5px;' /><a href='#' class='tree btn-exam-student'  level='".$tree[$uc_parent][$i]['level']."' uc='".$tree[$uc_parent][$i]['uc']."'>".$tree[$uc_parent][$i]['label']."</a></td>";
					} else if($tree[$uc_parent][$i]['type'] == 3) {
						echo "<td width='275'><img src='".base_url('assets/image/ico-exercise.png')."' width='15' height='15' style='margin:0px 5px 0px 5px;' /><a href='#' class='tree btn-exec-student' level='".$tree[$uc_parent][$i]['level']."' uc='".$tree[$uc_parent][$i]['uc']."'>".$tree[$uc_parent][$i]['label']."</a></td>";
					}
			echo "</tr>";

			if (count(@$tree[$tree[$uc_parent][$i]['uc']]) > 0) {
				courseware_browse_student($tree, $tree[$uc_parent][$i]['uc']);
			}
			
		}
	}
?>