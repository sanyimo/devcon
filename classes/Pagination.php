<?php

namespace Classes;

class Pagination {
    public int $current_page;
    public int $records_per_page;
    public int $total_registry;

    public function __construct(int $current_page = 1, int $records_per_page = 10, int $total_registry = 0 )
    {
        $this->current_page = $current_page;
        $this->records_per_page = $records_per_page;
        $this->total_registry = $total_registry;
    }
    public function offset(): int {
        return (int) ($this->records_per_page * ($this->current_page - 1));
    }
    public function total_pages(): int {
        $total = (int) ceil($this->total_registry / $this->records_per_page);
        return $total === 0 ? 1 : $total;
    }
    public function previous_page(): int|bool {
        $anterior = $this->current_page - 1;
        return ($anterior > 0) ? $anterior : false;
    }

    public function next_page(): int|bool {
        $siguiente = $this->current_page + 1;
        return ($siguiente <= $this->total_pages()) ? $siguiente : false;
    }
    public function prev_link(): string {
        $html = '';
        if($this->previous_page()) {
            $html .= "<a class=\"pagination__link pagination__link--text\" href=\"?page={$this->previous_page()}\">&laquo; Anterior </a>";
        }
        return $html;
    }

    public function next_link(): string {
        $html = '';
        if($this->next_page()) {
            $html .= "<a class=\"pagination__link pagination__link--text\" href=\"?page={$this->next_page()}\"> Siguiente &raquo;</a>";
        }
        return $html;
    }

    public function numbers_pages(): string {
        $html = '';
        for($i = 1; $i <= $this->total_pages(); $i++) {
            if($i === $this->current_page ) {
                $html .= "<span class=\"pagination__link pagination__link--current \">{$i}</span>";
            } else {
                $html .= "<a class=\"pagination__link pagination__link--number \" href=\"?page={$i}\">{$i}</a>";
            }
        }
        return $html;
    }

    public function pagination(): string {
        $html = '';
        if($this->total_registry > 1) {
            $html .= '<div class="pagination">';
            $html .= $this->prev_link();
            $html .= $this->numbers_pages();
            $html .= $this->next_link();
            $html .= '</div>';
        }
        return $html;
    }
}