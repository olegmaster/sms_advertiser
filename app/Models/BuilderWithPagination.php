<?php
/**
 * Created by PhpStorm.
 * User: shera
 * Date: 23.07.2020
 * Time: 14:36
 */

namespace App\Models;


use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Expression;

/**
 * This class provides a method for paging using SQL_CALC_FOUND_ROWS.
 * because Eloquent's paginate() method uses COUNT(*) which doesn't work with
 * GROUP BY. Every model which wants to use this class has to include it with:
 *      use path\to\BuilderWithPagination;
 * And then refer to it using a function like:
 *      public function newEloquentBuilder($query) {return new BuilderWithPagination($query);}
 * See http://www.tero.co.uk/scripts/builder-with-pagination.php for more details.
 */

class BuilderWithPagination extends Builder
{
    /** @var integer */
    private $do_paging = false;
    /** @var integer */
    private $total_rows_found = null;

    /**
     * Call this function to implement paging. It adds the
     * the LIMIT and OFFSET. Unlike paginate() it does not
     * return results directly but can be chained.
     *
     * @param integer $perPage
     * @param integer $page
     */
    public function addPagination($perPage = 15, $page = 1)
    {
        // We should do paging
        $this->do_paging = true;
        // Add the limit based on the $perPage
        $this->limit ($perPage);
        // Add the offset based on the page number
        $this->offset (($page>=1 ? $page-1 : 0) * $perPage);
        // Return me so calls can be chained
        return $this;
    }

    /**
     * This function overrides the normal getModels function which seems to
     * be called in all cases and allows us to get the total number of results.
     * It injects SQL_CALC_FOUND_ROWS to the front of the columns (adding
     * a dummy column to avoid an error with commas) and then calls
     * FOUND_ROWS immediately after the query is run.
     *
     * @param array $columns
     * @return mixed
     */
    public function getModels($columns = ['*'])
    {
        // We are doing paging
        if ($this->do_paging) {
            // The columns must be an array
            if (is_null($this->query->columns)) {
                $this->query->columns = is_array ($columns) ? $columns : array();
            }
            // This is for the special case when selecting * because in this
            // case the * needs to come first right after SQL_CALC_FOUND_ROWS
            // and we don't need the dummy column.
            if ($this->query->columns && $this->query->columns[0] == '*') {
                $this->query->columns[0] = new Expression ("SQL_CALC_FOUND_ROWS *");
            }
            // Or else add a new dummy column in front of all the other columns
            // so that I can put SQL_CALC_ROWS_FOUND and it will still work
            // properly when the other columns are joined by commas.
            else {
                $ex = new Expression ("SQL_CALC_FOUND_ROWS '0' AS paginator_dummy_column");
                array_unshift ($this->query->columns, $ex);
            }
        }

        //Run the query
        $results = $this->query->get($columns)->toArray();

        //Get the number of results
        $this->total_rows_found = DB::select(DB::raw('SELECT FOUND_ROWS() AS num'))[0]->num;

        //This came from the original getModels method.
        $connection = $this->model->getConnectionName();


        return $this->model->hydrate($results, $connection)->all();
    }

    /**
     * Override the normal count() function
     * @return integer
     */
    public function count()
    {
        return $this->total_rows_found;
    }

}

